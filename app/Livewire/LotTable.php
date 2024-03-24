<?php

namespace App\Livewire;

use App\Models\Lot;
use Livewire\Component;
use Livewire\WithPagination;


class LotTable extends Component
{
    use WithPagination;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public $sortBy = 'name'; // Initial sort
    public $sortDirection = 'asc';
    public $search = '';



    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when the search term changes
    }



    public function render()
    {
        $lots = Lot::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->where('user_id', auth()->id())
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.lot-tables', ['lots' => $lots]);
    }
}
