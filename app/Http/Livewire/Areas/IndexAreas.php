<?php

namespace App\Http\Livewire\Areas;

use App\Models\Area;
use Livewire\Component;
use Livewire\WithPagination;

class IndexAreas extends Component {

  use WithPagination;

  private $areas;
  public $search;

  protected $paginationTheme = 'simple-fomantic';
  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    if ($this->areas && $this->areas->count() === 0) {
      $this->resetPage();
    }

    $query = Area::query();

    if ($this->search) {
      $query->where('name', 'like', "%$this->search%");

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'No se encontraron coincidencias con la búsqueda.');
      } else {
        $this->emit('dismiss');
      }
    } elseif (empty($this->search)) {
      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'Todavía no hay ningún área registrada.');
      } else {
        $this->emit('dismiss');
      }
    }

    $query->orderBy('name');

    $this->areas = $query->paginate(6);

    if ($this->areas->currentPage() > $this->areas->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.areas.index-areas', ['areas' => $this->areas]);
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearSearch() {
    $this->reset();
    $this->resetErrorBag();
  }
}
