<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class IndexUsers extends Component {

  use WithPagination;

  private $users;
  public $search;

  protected $paginationTheme = 'fomantic';
  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    if ($this->users && $this->users->count() === 0) {
      $this->resetPage();
    }

    $query = User::query();

    if ($this->search) {
      $query->where('first_name', 'like', "%$this->search%")->orderBy('first_name');

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'No se encontraron coincidencias con la búsqueda.');
      } else {
        $this->emit('dismiss');
      }
    } elseif (empty($this->search)) {
      $query->orderBy('first_name');

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'Todavía no hay ningún área registrada.');
      } else {
        $this->emit('dismiss');
      }
    }

    $this->users = $query->paginate(10);

    if ($this->users->currentPage() > $this->users->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.users.index-users', ['users' => $this->users]);
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearSearch() {
    $this->reset();
    $this->resetErrorBag();
  }
}
