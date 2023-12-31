<?php

namespace App\Http\Livewire\Areas;

use App\Models\Area;
use Livewire\Component;
use Livewire\WithPagination;

class IndexAreas extends Component {

  use WithPagination;

  private $areas;
  private $modals;
  public $search;

  protected $paginationTheme = 'simple-fomantic';
  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    if ($this->areas && $this->areas->count() === 0) {
      $this->resetPage();
    }

    $query = Area::query();

    if ($this->search) {
      $query->where('name', 'like', "%$this->search%")->orderBy('name');

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'No se encontraron coincidencias con la búsqueda.');
      } else {
        $this->emit('dismiss');
      }
    } elseif (empty($this->search)) {
      $query->orderBy('name');

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'Todavía no hay ningún área registrada.');
      } else {
        $this->emit('dismiss');
      }
    }

    $this->areas = $query->paginate(6);

    if ($this->areas->currentPage() > $this->areas->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.areas.index-areas', ['areas' => $this->areas, 'modals' => $this->modals]);
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearSearch() {
    $this->reset();
    $this->resetErrorBag();
  }
}
