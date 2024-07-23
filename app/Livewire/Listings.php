<?php

namespace App\Livewire;

use App\Jobs\InsertTransaction;
use App\Jobs\UpdateItemStatus;
use App\Models\Category;
use App\Models\Item;
use App\Models\Lot;
use App\Rules\DateTimeBetween;
use App\Rules\TimeBetween;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ImageService;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Listings extends Component
{
    use WithFileUploads;

    public $selectedLot;

    public $title;
    public $description;
    public $starting_bid;

    public $current_bid;

    public $reserve_price;
    public $start_time;
    public $end_time;
    public $status;
    public $statusOption = ['available', 'pending', 'sold'];

    public $formAction = 'submit';
    public $mode = 'create';

    public $files = [];
    public $images = [];

    public $itemId;
    public $category = [];
    public $showModal = false;


    //Check if selected lot has change, if so reset fields
    public function updatedSelectedLot()
    {
        $this->resetFields();
    }

    public function rules()
    {
        $selectedLot = Lot::find($this->selectedLot);
        $selectedLotStartDate = $selectedLot->start_date;
        $selectedLotEndDate = $selectedLot->end_date;

        $userStartTime = Carbon::createFromFormat('Y-m-d\TH:i', $this->start_time, 'UTC');
        $userEndTime = Carbon::createFromFormat('Y-m-d\TH:i', $this->end_time, 'UTC');

        Log::info('Selected Lot Start Date: ' . $selectedLotStartDate);
        Log::info('Selected Lot End Date: ' . $selectedLotEndDate);

        Log::info('start_time: ' . $userStartTime);
        Log::info('end_time: ' . $userEndTime);

        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'starting_bid' => 'required|decimal:2',
            'reserve_price' => 'required|decimal:2',
            'category' => 'required|array',
            'category.*' => Rule::exists('categories', 'id'),
            'start_time' => [
                'nullable',
                'date_format:Y-m-d\TH:i',
                new DateTimeBetween($selectedLotStartDate, $selectedLotEndDate)
            ],
            'end_time' => [
                'nullable',
                'date_format:Y-m-d\TH:i',
                new DateTimeBetween($selectedLotStartDate, $selectedLotEndDate)
            ],
            'status' => 'required|string',
            'files.*' => 'sometimes|image|max:1024',
        ];
    }


    public function create()
    {

        $selectedLot = Lot::find($this->selectedLot);
        $this->validate();

        $item = new Item();
        $item->title = $this->title;
        $item->description = $this->description;
        $item->starting_bid = $this->starting_bid;
        $item->current_bid = $this->starting_bid;
        $item->reserve_price = $this->reserve_price;

        //if start time and end time are empty, extract times from selected lot
        if (empty($this->start_time)) {
            $startTime = $selectedLot->start_date;
            $this->start_time = $selectedLot->start_date;
        }
        if (empty($this->end_time)) {
            $endTime = $selectedLot->end_date;
            $this->end_time = $selectedLot->end_date;
        }

        // Convert user-set time into UTC
        $userTimezone = auth()->user()->timezone; // Set this based on your authenticated user's timezone
        $startTime = Carbon::createFromFormat('Y-m-d\TH:i', $this->start_time, $userTimezone)->setTimezone('UTC');
        $endTime = Carbon::createFromFormat('Y-m-d\TH:i', $this->end_time, $userTimezone)->setTimezone('UTC');

        $item->start_time = $startTime;
        $item->end_time = $endTime;
        $item->status = $this->status;
        $item->lot_id = $this->selectedLot;
        $item->user_id = auth()->id();

        $item->save();

        $imageService = new ImageService();
        if (!empty($this->files)) {
            $subfolder = $item->id . $item->title;
            $this->images[] = $imageService->saveBulkImages($this->files, 'items', $subfolder, $item->images);
        }

        if (!empty($this->images)) {
            //turn to json for json data type
            $item->images = json_encode($this->images);
            $item->save();
        }

        $item->categories()->attach($this->category);

        //Dispatch the job
        $this->jobDispatch($item);

        $this->resetFields();

        session()->flash('message', 'Item created successfully');

    }

    public function update()
    {
        logger('validating');

        $this->validate();

        logger($this->itemId ?? 'no item id');

        $item = Item::query()
            ->where('user_id', auth()->id())
            ->where('lot_id', $this->selectedLot)
            ->where('id', $this->itemId)
            ->first();

        $imageService = new ImageService();

        if (!empty($this->files)) {
            //Bulk Delete images
            $imageService->deleteBulkImages($item->images, 'items');
            $this->images = [];
            $subfolder = $item->id . $item->title;
            $this->images[] = $imageService->saveBulkImages($this->files, 'items', $subfolder, $item->images);
        }

        // Convert user-set time into UTC
        $userTimezone = auth()->user()->timezone; // Set this based on your authenticated user's timezone

        $start_time = Carbon::createFromFormat('Y-m-d\TH:i', $this->start_time, $userTimezone)->setTimezone('UTC');
        $end_time = Carbon::createFromFormat('Y-m-d\TH:i', $this->end_time, $userTimezone)->setTimezone('UTC');
        // Save UTC times in database
        $item->update([
            'title' => $this->title,
            'description' => $this->description,
            'starting_bid' => $this->starting_bid,
            'current_bid' => $this->current_bid,
            'reserve_price' => $this->reserve_price,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $this->status,
        ]);

        if (!empty($this->images)) {
            //turn to json for json data type
            $item->images = json_encode($this->images);
            $item->update();
        }

        $item->categories()->sync($this->category);

        //Dispatch the job
        $this->jobDispatch($item);

        $this->resetFields();

        session()->flash('message', 'Item updated successfully');

    }

    #[On('edit')]
    public function edit($id): void
    {
        $this->images = [];

        $item = Item::query()
            ->where('user_id', auth()->id())
            ->where('id', $id)
            ->where('lot_id', $this->selectedLot)
            ->first();

        $this->title = $item->title;
        $this->description = $item->description;
        $this->starting_bid = $item->starting_bid;
        $this->current_bid = $item->current_bid;
        $this->reserve_price = $item->reserve_price;
        $this->start_time = Carbon::parse($item->start_time)->inUserTimezone()->format('Y-m-d\TH:i');
        $this->end_time = Carbon::parse($item->end_time)->inUserTimezone()->format('Y-m-d\TH:i');
        $this->status = $item->status;
        $this->images = $item->images;
        $this->itemId = $item->id;
        $this->category = $item->categories->pluck('id')->toArray();
        //decode json images
        $this->images = json_decode($this->images);

        // Make sure the images is an array of arrays
        if ($this->isArrayOfArrays($this->images)) {
            $this->images = array_reduce($this->images, 'array_merge', array());
        }

        $this->mode = 'edit';
    }

    #[On('delete')]
    public function delete($itemId): void
    {
        $item = Item::query()
            ->where('user_id', auth()->id())
            ->where('lot_id', $this->selectedLot)
            ->where('id', $itemId)
            ->first();

        if (!empty($item)) {
            $imageService = new ImageService();
            //Bulk Delete images
            $imageService->deleteBulkImages($item->images, 'items');
            $item->delete();
            session()->flash('message', 'Item deleted successfully');
        }
    }

    public function submit(): void
    {
        logger($this->mode);

        if ($this->mode == 'create') {
            $this->create();
        } else {
            logger('updating');
            $this->update();
        }
    }

    private function resetFields(): void
    {
        $this->title = '';
        $this->description = '';
        $this->starting_bid = '';
        $this->current_bid = '';
        $this->reserve_price = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->status = '';
        $this->images = [];
        $this->files = [];
    }


    function isArrayOfArrays(array $array): bool
    {
        foreach ($array as $element) {
            if (!is_array($element)) {
                return false;
            }
        }

        return true;
    }

    public function jobDispatch($item) : void
    {
        //Get the Timezone of the authenticated user
        $userTimezone = auth()->user()->timezone;

        //Fetch the end time of the item.
        $endTime = $this->end_time;
        Log::info('End Time: ' . $endTime);

        //Reformat the end time to the user's timezone
        $endTimeConvert = Carbon::createFromFormat('Y-m-d\TH:i', $endTime, $userTimezone);
        $currentTime = now()->setTimezone($userTimezone);
        $adjustedNow = $currentTime->copy()->startOfMinute();

        Log::info('End Time Converted: ' . $endTimeConvert);
        Log::info('Current Time: ' . $currentTime);
        Log::info('Adjusted Now: ' . $adjustedNow);

        //If the end time is now or in the past, dispatch the job immediately
        if ($endTimeConvert->lessThanOrEqualTo($adjustedNow)) {
            Log::error("The end time is in the past or now, dispatching UpdateItemStatus immediately.");
            UpdateItemStatus::withChain([
                //Chain the job with another job
                //This job will be dispatched immediately after the UpdateItemStatus job is completed
                new InsertTransaction($item)
            ])->dispatch($item);

        }else {
            //If the end time is in the future, dispatch the job with a delay
            UpdateItemStatus::dispatch($item)->delay($endTimeConvert)->chain([
                new InsertTransaction($item)
            ]);
        }
    }


    public function render()
    {
        $lots = Lot::where('user_id', auth()->id())->get();
        $categories = Category::all();



        if (!empty($this->selectedLot)) {
            $items = Item::query()
                ->where('lot_id', $this->selectedLot)
                ->where('user_id', auth()->id())
                ->get();

            $singleLot = Lot::query()
                ->where('user_id', auth()->id())
                ->where('id', $this->selectedLot)
                ->first();
        }
        $columns = [
            ['field' => 'title', 'label' => 'Title'],
            ['field' => 'description', 'label' => 'Description'],
            ['field' => 'starting_bid', 'label' => 'Starting Bid'],
            ['field' => 'current_bid', 'label' => 'Current Bid'],
            ['field' => 'reserve_price', 'label' => 'Reserve Price'],
            ['field' => 'start_time', 'label' => 'Start Time'],
            ['field' => 'end_time', 'label' => 'End Time'],
            ['field' => 'status', 'label' => 'Status'],

        ];
        return view('livewire.listings', [
            'lots' => $lots,
            'columns' => $columns,
            'items' => $items ?? [],
            'singleLot' => $singleLot ?? [],
            'categories' => $categories,
        ]);
    }
}
