<?php

namespace App\Http\Livewire\Companies;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class IndexCompanies extends Component {

  use WithPagination;

  private $companies;
  public $search;

  protected $paginationTheme = 'fomantic';
  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    if ($this->companies && $this->companies->count() === 0) {
      $this->resetPage();
    }

    $query = Company::query();

    if ($this->search) {
      $query->where('name', 'like', "%$this->search%");

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'No se encontraron coincidencias con la búsqueda.');
      } else {
        $this->emit('dismiss');
      }
    } elseif (empty($this->search)) {
      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'Todavía no hay ninguna empresa registrada.');
      } else {
        $this->emit('dismiss');
      }
    }

    $query->orderBy('name');

    $this->companies = $query->paginate(10);

    if ($this->companies->currentPage() > $this->companies->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.companies.index-companies', ['companies' => $this->companies]);
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearSearch() {
    $this->reset();
    $this->resetErrorBag();
  }
}
