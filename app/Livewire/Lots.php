<?php

namespace App\Livewire;

use App\Models\Lot;
use Livewire\Component;

class Lots extends Component
{
    public $title;
    public $description;
    public $image;
    public $status = ['upcoming', 'live', 'closed'];
    public $start_date;
    public $end_date;

    //Validation rules
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|image|max:1024',
            'status' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ];
    }

    //Create a lot
    public function create()
    {
        $this->validate();

        auth()->user()->lots()->create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image->store('lots'),
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ]);

        $this->title = '';
        $this->description = '';
        $this->image = '';
        $this->status = '';
        $this->start_date = '';
        $this->end_date = '';
    }

    //Update a lot
    public function update($lotId)
    {
        $lot = auth()->user()->lots()->where('id', $lotId)->first();
        $lot->update([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image->store('lots'),
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ]);
    }

    //Delete a lot
    public function delete($lotId)
    {
        $lot = auth()->user()->lots()->where('id', $lotId)->first();
        $lot->delete();
    }

    public function render()
    {
        //Get lots that belong to the user
        $lots = Lot::where('user_id', auth()->id())->get();

        return view('livewire.lots',[
            'lots' => $lots,
        ]);
    }
}
