<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Lot;
use Livewire\Component;

class Listings extends Component
{
    public $selectedLot;

    public $title;
    public $description;
    public $starting_bid;
    public $current_bid;
    public $reserve_price;
    public $start_time;
    public $end_time;
    public $status;
    public $images;

    public $mode = 'create';

    public function rules(){
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'starting_bid' => 'required|numeric',
            'current_bid' => 'required|numeric',
            'reserve_price' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'status' => 'required|string',
            'images' => 'required|json',
        ];
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function edit($id) : void
    {
        $item = Item::query()
            ->where('user_id', auth()->id())
            ->where('lot_id', $this->selectedLot)
            ->get();

        $this->title = $item->title;
        $this->description = $item->description;
        $this->starting_bid = $item->starting_bid;
        $this->current_bid = $item->current_bid;
        $this->reserve_price = $item->reserve_price;
        $this->start_time = $item->start_time;
        $this->end_time = $item->end_time;
        $this->status = $item->status;
        $this->images = $item->images;

        $this->mode = 'edit';
    }

    public function submit(): void
    {
        if ($this->mode == 'create') {
            $this->create();
        } else {
            $this->update();
        }
    }

    private function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->starting_bid = '';
        $this->current_bid = '';
        $this->reserve_price = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->status = '';
        $this->images = '';
        $this->selectedLot = null;
    }


    public function render()
    {
        $lots = Lot::where('user_id', auth()->id())->get();


        if(!empty($this->selectedLot)){
            $items = Item::query()
                ->where('lot_id', $this->selectedLot)
                ->where('user_id', auth()->id())
                ->get();

            $singleLot = Lot::query()
                ->where('user_id', auth()->id())
                ->where('id', $this->selectedLot)
                ->first();
        }
        $columns= [
            ['field'=> 'title', 'label'=> 'Title'],
            ['field'=> 'description', 'label'=> 'Description'],
            ['field'=> 'starting_bid', 'label'=> 'Starting Bid'],
            ['field'=> 'current_bid', 'label'=> 'Current Bid'],
            ['field'=> 'reserve_price', 'label'=> 'Reserve Price'],
            ['field'=> 'start_time ', 'label'=> 'Start Time'],
            ['field'=> 'end_time', 'label'=> 'End Time'],
            ['field'=> 'status', 'label'=> 'Status'],

        ];
        return view('livewire.listings',[
            'lots' => $lots,
            'columns' => $columns,
            'items' => $items ?? [],
            'singleLot' => $singleLot ?? [],
        ]);
    }
}
