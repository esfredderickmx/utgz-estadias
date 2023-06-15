<?php

namespace App\Http\Livewire\Careers;

use App\Models\Career;
use Livewire\Component;
use Livewire\WithPagination;

class IndexCareers extends Component {

  use WithPagination;

  private $careers;
  private $modals;
  public $search;

  protected $paginationTheme = 'fomantic';
  protected $listeners = ['refresh' => '$refresh'];

  public function mount() {
    $this->emit('refresh');
  }
  
  public function render() {
    if ($this->careers && $this->careers->count() === 0) {
      $this->resetPage();
    }

    $query = Career::query();

    if ($this->search) {
      $query->where('name', 'like', "%$this->search%")->orderBy('area_id');

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'No se encontraron coincidencias con la búsqueda.');
      } else {
        $this->emit('dismiss');
      }
    } elseif (empty($this->search)) {
      $query->orderBy('area_id');

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'Todavía no hay ningún área registrada.');
      } else {
        $this->emit('dismiss');
      }
    }

    $this->careers = $query->paginate(6);

    if ($this->careers->currentPage() > $this->careers->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.careers.index-careers', ['careers' => $this->careers, 'modals' => $this->modals]);
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearSearch() {
    $this->reset();
    $this->resetErrorBag();
  }
}
