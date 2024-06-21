<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AuctionItems extends Component
{

    use WithPagination;
    //page title

    public $items;
    public $status = '';
    #[Url]
    public $search = '';
    public $perPage = 10;
    public $start_time;
    public $end_time;

    public $id;



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
        $this->id = $id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status', 'start_time', 'end_time']);
    }



    public function render()
    {
        return view('livewire.auction.auction-items', [
            'auctionItems' => Item::where('lot_id', $this->id)
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                ->when($this->status, function ($query) {
                    $query->where('status', $this->status);
                })
                ->when($this->start_time, function ($query) {
                    $query->where('start_time', '>=', $this->start_time);
                })
                ->when($this->end_time, function ($query) {
                    $query->where('end_time', '<=', $this->end_time);
                })
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);

    }
}
