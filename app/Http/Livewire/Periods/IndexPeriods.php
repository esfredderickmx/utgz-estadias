<?php

namespace App\Http\Livewire\Periods;

use App\Models\Period;
use App\Models\Periods;

use Livewire\Component;
use Livewire\WithPagination;

class IndexPeriods extends Component {

  use WithPagination;

  private $periods;
  public $quarter_search;
  public $year_search;

  protected $paginationTheme = 'fomantic';
  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    if ($this->periods && $this->periods->count() === 0) {
      $this->resetPage();
    }

    $query = Period::query();

    if ($this->quarter_search || $this->year_search) {
      if ($this->quarter_search) {
        $query->where('quarter', 'like', "%$this->quarter_search%");
      }

      if ($this->year_search) {
        $query->where('year', 'like', "%$this->year_search%");
      }

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'No se encontraron coincidencias con la búsqueda.');
      } else {
        $this->emit('dismiss');
      }
    } elseif (empty($this->quarter_search) && empty($this->year_search)) {
      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'Todavía no hay ningún periodo registrado.');
      } else {
        $this->emit('dismiss');
      }
    }

    $query->orderBy('year')->orderBy('quarter');

    $this->periods = $query->paginate(12);

    if ($this->periods->currentPage() > $this->periods->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.periods.index-periods', ['periods' => $this->periods]);
  }

  public function updatedQuarterSearch() {
    $this->resetPage();
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearYearSearch() {
    $this->reset('year_search');
    $this->emit('year-search-reset');
  }

  public function clearSearch() {
    $this->emit('year-search-reset');
    $this->reset();
    $this->resetErrorBag();
  }
}
