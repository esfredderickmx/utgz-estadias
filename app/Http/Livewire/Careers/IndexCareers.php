<?php

namespace App\Http\Livewire\Careers;

use App\Models\Career;
use Livewire\Component;
use Livewire\WithPagination;

class IndexCareers extends Component {

  use WithPagination;

  private $careers;
  public $search;

  protected $paginationTheme = 'fomantic';
  protected $listeners = ['refresh' => '$refresh'];
  
  public function render() {
    if ($this->careers && $this->careers->count() === 0) {
      $this->resetPage();
    }

    $query = Career::query();

    if ($this->search) {
      $query->where('name', 'like', "%$this->search%")->orWhere('context', 'like', "%$this->search%");

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

    $query->orderBy('area_id')->orderBy('grade')->orderBy('name');

    $this->careers = $query->paginate(6);

    if ($this->careers->currentPage() > $this->careers->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.careers.index-careers', ['careers' => $this->careers]);
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearSearch() {
    $this->reset();
    $this->resetErrorBag();
  }
}
