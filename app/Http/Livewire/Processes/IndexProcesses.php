<?php

namespace App\Http\Livewire\Processes;

use App\Models\Process;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProcesses extends Component {

  use WithPagination;

  private $processes;
  public $users_search;
  public $type_search;
  public $status_search;

  protected $paginationTheme = 'fomantic';
  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    if ($this->processes && $this->processes->count() === 0) {
      $this->resetPage();
    }

    $query = Process::query();

    if ($this->users_search || $this->type_search || $this->status_search) {
      if ($this->users_search) {
        $query->whereHas('users', function($users_query) {
          $users_query->where(function ($sub_query) {
            $sub_query->where('first_name', 'like', "%$this->users_search%")->orWhere('last_name', 'like', "%$this->users_search%");
          });
        });
      }

      if ($this->type_search) {
        $query->where('type', $this->type_search);
      }

      if ($this->status_search) {
        if($this->status_search==='finished') {
          $query->whereIn('status', ['approved', 'unapproved']);
        } else {
          $query->where('status', $this->status_search);
        }
      }

      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'No se encontraron coincidencias con la búsqueda.');
      } else {
        $this->emit('dismiss');
      }
    } elseif (empty($this->users_search) && empty($this->type_search) && empty($this->status_search)) {
      if ($query->count() === 0) {
        $this->emit('toast', 'info', 'Todavía no hay ningún proceso registrado.');
      } else {
        $this->emit('dismiss');
      }
    }

    $query->orderBy('type')->orderBy('status');

    $this->processes = $query->paginate(9);

    if ($this->processes->currentPage() > $this->processes->lastPage()) {
      $this->resetPage();
      $this->render();
    }

    return view('livewire.processes.index-processes', ['processes' => $this->processes]);
  }

  public function handleSearch() {
    $this->resetPage();
  }

  public function clearUsersSearch() {
    $this->reset('users_search');
  }

  public function clearSearch() {
    $this->reset();
    $this->resetErrorBag();
  }
}
