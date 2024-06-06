<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AuctionItems extends Component
{

    //page title

    public $items;


    #[Computed]
    public function bgColor($status)
    {
       if ($status == 'available') {
           return 'bg-green-500';
       } elseif ($status == 'pending') {
           return 'bg-yellow-200';
       } elseif ($status == 'sold') {
           return 'bg-red-200';
       }
       return 'bg-gray-200';
    }


    #[Layout('components.layouts.auction')]
    public function mount($id)
    {
        //get all items where lot_id is equal to the id
        $this->items = Item::where('lot_id', $id)->get();

    }

    public function render()
    {
        return view('livewire.auction.auction-items', [
            'auctionItems' => $this->items
        ]);

    }
}
