<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
      $query->where(function ($subquery) {
        $subquery->where('first_name', 'like', "%$this->search%")->orWhere('last_name', 'like', "%$this->search%");
      });

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

    if(Auth::user()->role!=='super') {
      $query->where('role', '!=', 'super');
    }
    $query->orderBy('first_name');
    
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
