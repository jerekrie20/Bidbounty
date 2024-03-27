<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;

class DisplayData extends Component
{

    use WithPagination;

    public $columns = [];

    public $model;

    #[Reactive]
    public $id;
    public $columnID;
    public $search = '';
    public $sortBy = '';
    public $sortDirection = 'asc';
    public $perPage = 10;

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





    public function render()
    {
        $fullModel = null;

        switch ($this->model) {
            case "Item":
                $fullModel = "\\App\\Models\\Item";
                break;
            // add more model alias here
        }

        if(empty($this->sortBy)){
            $this->sortBy = 'title';
        }

        $data = [];
        if (!empty($this->id) && !empty($this->model)) {
            $data = $fullModel::query()
                ->where($this->columnID, $this->id)
                ->where('title', 'like', '%' . $this->search . '%')
                ->where('user_id', auth()->id())
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
        }

        return view('livewire.display-data', [
            'data' => $data,
        ]);
    }
}
