<?php

namespace App\Livewire;

use App\Jobs\EndLotAuction;
use App\Jobs\UpdateLotStatus;
use App\Models\AuctionCategory;
use App\Models\Category;
use App\Models\Lot;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class Lots extends Component
{
    use WithPagination, WithFileUploads;

    public $title;
    public $description;
    public $image;
    public $status;
    public $statusOption = ['upcoming', 'live', 'pending', 'closed'];
    public $start_date;
    public $end_date;
    #[Locked]
    public $lotId;

    public $mode = 'create';
    public $formAction = 'submit';

    public $category = [];

    public $sortBy = '';
    public $sortDirection = 'asc';
    public $perPage = 10;
    #[Url]
    public $search = '';

    //Validation rules
    public function rules()
    {

        if ($this->mode == 'create') {
            return [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'image' => 'nullable|image|max:1024',
                'category' => 'required|array',
                'category.*' => Rule::exists('categories', 'id'),
                'start_date' => 'required|date_format:Y-m-d\TH:i|after_or_equal:today',
                'end_date' => 'required|date_format:Y-m-d\TH:i|after_or_equal:today|after:start_date',
            ];
        } else {
            return [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'image' => 'nullable|image|max:1024',
                'category' => 'required|array',
                'category.*' => Rule::exists('categories', 'id'),
                'start_date' => 'required|date_format:Y-m-d\TH:i',
                'end_date' => 'required|date_format:Y-m-d\TH:i|after:start_date',
            ];
        }

    }

    public function sortField($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';  // Reset to ascending when sorting by a new field
        }


        $this->resetPage(); // Reset pagination
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    //Create a lot
//Create a lot
    public function create()
    {
        $this->validate();
        $imageService = new ImageService();
        //Validate the image, store it in the lots folder and create a new lot
        if ($this->image) {
            $this->image = $imageService->saveImage($this->image, auth()->user(), 'lotImages');
        }
        $lot = auth()->user()->lots()->create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ]);
        //add category to pivot table
        $lot->categories()->attach($this->category);

        $this->resetFields();
        session()->flash('success', 'Created successfully');
    }

    public function edit($lotId): void
    {
        $lot = Lot::find($lotId);

        $this->authorize('edit', $lot); // Check if the user is authorized to edit the lot (Policy)

        $this->title = $lot->title;
        $this->description = $lot->description;
        $this->status = $lot->status;
        $this->start_date = \Carbon\Carbon::parse($lot->start_date)->format('Y-m-d\TH:i');
        $this->end_date = \Carbon\Carbon::parse($lot->end_date)->format('Y-m-d\TH:i');
        $this->lotId = $lot->id; // update $lotId

        $this->category = $lot->categories->pluck('id')->toArray();
        $this->mode = 'edit'; // Change the mode to edit

        $this->dispatch('scrollToTop');

//        Log::info('Edit method called with lotId:' . $this->lotId);
    }

//Update a lot
    public function update(): void
    {
        $this->validate();
        $lot = Lot::find($this->lotId);

        $this->authorize('update', $lot); // Check if the user is authorized to update the lot (Policy)

        $imageService = new ImageService();
        //If image is set, update the image, otherwise keep the old image
        if ($this->image) {
            $this->image = $imageService->saveImage($this->image, $lot->image, 'lotImages');
        } else {
            $this->image = $lot->image;
        }
        $lot->update([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ]);
        // Sync categories
        $lot->categories()->sync($this->category);
        // Add Job to update the status of the lot
        $timezone = auth()->user()->timezone;

        // Fetching the start_date and end_date as strings first
        $startDateString = $this->start_date;
        $endDateString = $this->end_date;

        Log::info('Form Start Date: ' . $startDateString);
        Log::info('Form End Date: ' . $endDateString);

        // Correctly interpret the datetime strings with the correct timezone
        $auctionStartDateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $startDateString, $timezone);
        $auctionEndDateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $endDateString, $timezone);

        $currentTime = now()->setTimezone($timezone);
        $adjustedNow = $currentTime->copy()->startOfMinute();

        Log::info('Auction Start DateTime: ' . $auctionStartDateTime . ' Timezone: ' . $auctionStartDateTime->timezone);
        Log::info('Current Time: ' . $currentTime . ' Timezone: ' . $currentTime->timezone);
        Log::info('Adjusted Now: ' . $adjustedNow . ' Timezone: ' . $adjustedNow->timezone);

        // if the start time is in the future
        if ($auctionStartDateTime->greaterThanOrEqualTo($adjustedNow)) {
            UpdateLotStatus::dispatch($lot)->delay($auctionStartDateTime);
        } else {
            // handle this case, either dispatch immediately, log an error, etc.
            Log::error("The start time is in the past or now, dispatching UpdateLotStatus immediately.");
//            dd($auctionStartDateTime, $adjustedNow);
            UpdateLotStatus::dispatchSync($lot);
        }

        // if the end time is in the future
        if ($auctionEndDateTime->greaterThan($currentTime)) {
            EndLotAuction::dispatch($lot)->delay($auctionEndDateTime);
        } else {
            // handle this case, either dispatch immediately, log an error, etc.
            EndLotAuction::dispatchSync($lot);
        }

        $this->resetFields();
        session()->flash('success', 'Updated successfully!');
    }







    //Delete a lot
    public function delete($lotId): void
    {
        $lot = Lot::find($lotId);

        //If the user is not the owner of the lot, return an error message

        $this->authorize('delete', $lot);

        //Delete the image
        $imageService = new ImageService();
        $imageService->deleteImage($lot->image, 'lotImages');

        $lot->delete();
    }

    private function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->status = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->image = '';
        $this->category = []; //
        $this->lotId = null;
    }

    public function submit(): void
    {
        if ($this->mode == 'create') {
            $this->create();
        } else {
            $this->update();
        }
    }

    public function render()
    {

        $categories = AuctionCategory::all();

        //Get lots that belong to the user
        if ($this->sortBy == '') {
            $this->sortBy = 'id';
        }
        $lots = Lot::query()
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->where('user_id', auth()->user()->id)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

//        dd($lots);

        return view('livewire.lots', [
            'lots' => $lots,
            'categories' => $categories
        ]);
    }
}
