<?php

namespace App\Livewire;

use App\Models\Bid;
use App\Models\Country;
use App\Models\Item;
use App\Models\Lot;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\BidService;

class AuctionSingleItem extends Component
{
    public $itemId;
    public $lotId;
    public $item;
    public $lot;
    public $showModal = false;
    public $bidAmount;

    public $bidTime = false;
    public $bids;
    public $wish = false;

    //Events
    #[On('echo:development,BidPlaced')]
    public function handleBidPlaced()
    {
        Log::info('BidPlaced event received');
        $this->refreshBids();
    }

    //Listen for the event
    #[On('echo:development,ItemStatusUpdated')]
    public function handleItemStatusUpdated()
    {
        Log::info('ItemStatusUpdated event received');
        session()->flash('notice', 'Item status updated!');
        // Refresh the item
    }


    //End Events

    public function refreshBids()
    {
        $this->bids = Bid::where('item_id', $this->itemId)
            ->orderBy('created_at', 'desc') // Order by created_at to get the latest bids
            ->limit(5)
            ->get();
    }


    // Reset bid amount
    public function resetBidAmount()
    {
        $this->bidAmount = '';
    }

    // Set color for status
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

    // Check if bidding is open
    public function biddingTime(): void
    {
        $current_time = \Carbon\Carbon::now()->inUserTimezone();

        // Check if lot is live
        if ($this->lot->status != 'live') {
            $this->bidTime = false;
            return;
        }

        if($this->item->status == 'pending' || $this->item->status == 'sold') {
            $this->bidTime = false;
            return;
        }

        // Convert strings to time format using Carbon
        $start_time = \Carbon\Carbon::parse($this->item->start_time)->inUserTimezone();
        $end_time = \Carbon\Carbon::parse($this->item->end_time)->inUserTimezone();

//        dd($current_time, $start_time, $end_time);

        $this->bidTime = $current_time->between($start_time, $end_time);

    }

    public function customBid()
    {
        $this->biddingTime();

        if (!$this->bidTime) { // Check if bidding is open
            session()->flash('error', 'Bidding is closed!');
            return;
        }

        $this->validate([
            'bidAmount' => ['required', 'numeric', 'gte:' . $this->item->starting_bid],
        ]);

        // Check if bid amount is greater than current bid
        $currentBid = Bid::where('item_id', $this->itemId)->orderBy('amount', 'desc')->first();

        if ($currentBid && $this->bidAmount <= $currentBid->amount) {
            session()->flash('error', 'Bid amount must be greater than current bid!');
            $this->resetBidAmount();
            return;
        }

        $bidData = [
            'item_id' => $this->itemId,
            'user_id' => auth()->id(),
            'amount' => $this->bidAmount
        ];

        app(BidService::class)->placeBid($bidData);

        session()->flash('success', 'Bid placed successfully!');
        $this->resetBidAmount();

    }

    #[On('buyNow')]
    public function buyNow()
    {
        $this->biddingTime();

        if (!$this->bidTime) { // Check if bidding is open
            session()->flash('error', 'Bidding is closed!');
            return;
        }

        $bidData = [
            'item_id' => $this->itemId,
            'user_id' => auth()->id(),
            'amount' => $this->item->reserve_price
        ];

        app(BidService::class)->placeBid($bidData);

        // Update the item status to pending
        $this->item->update(['status' => 'pending']);

        session()->flash('success', 'Bid placed successfully!');
    }

    #[On('bidNow')]
    public function bidNow()
    {
        $this->biddingTime();

        if (!$this->bidTime) { // Check if bidding is open
            session()->flash('error', 'Bidding is closed!');
            return;
        }

        $bidData = [
            'item_id' => $this->itemId,
            'user_id' => auth()->id(),
            'amount' => $this->item->current_bid + 100
        ];

        app(BidService::class)->placeBid($bidData);

        session()->flash('success', 'Bid placed successfully!');

    }

    #[On('wishlist')]
    public function wishlist() // Add item to wishlist
    {
        $item = Item::find($this->itemId);
        $item->watchlists()->create([
            'user_id' => auth()->id(),
            'item_id' => $this->itemId
        ]);
        $this->wish = true;
        session()->flash('success', 'Item added to wishlist!');
    }
    #[On('removeWishlist')]
    public function removeWishlist() // Remove item from wishlist
    {
        $item = Item::find($this->itemId);
        $item->watchlists()->where('user_id', auth()->id())->delete();
        $this->wish = false;
        session()->flash('success', 'Item removed from wishlist!');
    }

    #[Layout('components.layouts.auction')]
    public function mount($lotId, $itemId)
    {
        $this->lotId = $lotId;
        $this->itemId = $itemId;
        $this->item = Item::find($this->itemId);
        $this->lot = Lot::find($this->lotId);
        // Check if item is in wishlist
        $this->wish = $this->item->watchlists()->where('user_id', auth()->id())->exists();
        // Initialize the bids
        $this->refreshBids();
    }

    public function render()
    {

        return view('livewire.auction.auction-single-item', [
            'item' => $this->item,
            'lot' => $this->lot,
            'bids' => $this->bids,
        ]);
    }
}
