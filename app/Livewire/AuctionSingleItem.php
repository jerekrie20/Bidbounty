<?php

namespace App\Livewire;

use App\Models\Bid;
use App\Models\Item;
use App\Models\Lot;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AuctionSingleItem extends Component
{
    public $itemId;
    public $lotId;

    public $showModal = false;
    public $showBidModal = false;

    public $bidAmount;

    public $bidTime = false;

    //reset bid amount
    public function resetBidAmount()
    {
        $this->bidAmount = '';
    }

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

    public function bidingTime(){
        $current_time = \Carbon\Carbon::now('America/Chicago');

        //Check if lot is live
        $lot = Lot::find($this->lotId);
        if ($lot->status != 'live') {
            $this->bidTime = false;
        }
        //Check if biding is open
        $item = Item::find($this->itemId);
        // Convert strings to time format using Carbon
        $start_time = \Carbon\Carbon::createFromFormat('H:i:s', $item->start_time, 'UTC')->setTimezone('America/Chicago');
        $end_time = \Carbon\Carbon::createFromFormat('H:i:s', $item->end_time, 'UTC')->setTimezone('America/Chicago');

        dd($current_time, $start_time, $end_time);

        dd($current_time->between($start_time, $end_time));


        $this->bidTime = $item->start_time <= now() && now() <= $item->end_time;

        dd($this->bidTime);
    }


    public function customBid()
    {
//        $this->bidingTime();
//
//        if(!$this->bidTime){
//            session()->flash('error', 'Bidding is closed!');
//            return;
//        }
        $this->validate([
            'bidAmount' => 'required|numeric'
        ]);

        //check if bid amount is greater than current bid
        $currentBid = Bid::where('item_id', $this->itemId)->orderBy('amount', 'desc')->first();

        if ($currentBid && $this->bidAmount <= $currentBid->amount) {
            //Clear Session
            session()->forget('error');
            session()->flash('error', 'Bid amount must be greater than current bid!');
            $this->resetBidAmount();
            return;
        }

        //save bid in bids table
        Bid::create([
            'item_id' => $this->itemId,
            'user_id' => auth()->id(),
            'amount' => $this->bidAmount
        ]);

        session()->flash('success', 'Bid placed successfully!');
        $this->resetBidAmount();
    }


    #[Layout('components.layouts.auction')]
    public function mount($lotId, $itemId)
    {
        $this->lotId = $lotId;
        $this->itemId = $itemId;

    }

    public function render()
    {
        return view('livewire.auction.auction-single-item', [
            'item' => Item::find($this->itemId),
            'lot' => Lot::find($this->lotId),
            'bids' => Bid::where('item_id', $this->itemId)->orderBy('amount', 'desc')->limit(5)->get(),
        ]);
    }
}
