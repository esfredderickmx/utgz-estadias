<?php

namespace App\Http\Livewire\Processes;

use App\Models\Process;
use Illuminate\Support\Facades\Auth;
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

    $query = Process::query()->select('processes.*', 'periods.quarter as period_quarter', 'periods.year as period_year');
    
    if (Auth::user()->role === 'student' || Auth::user()->role === 'adviser') {
      $query->whereHas('users', function ($auth_query) {
        $auth_query->where('user_id', Auth::user()->id);
      });
    }

    if ($this->users_search || $this->type_search || $this->status_search) {
      if ($this->users_search) {
        $query->whereHas('users', function ($users_query) {
          $users_query->where(function ($sub_query) {
            $sub_query->where('first_name', 'like', "%$this->users_search%")->orWhere('last_name', 'like', "%$this->users_search%");
          });
        });
      }

      if ($this->type_search) {
        $query->where('type', $this->type_search);
      }

      if ($this->status_search) {
        if ($this->status_search === 'finished') {
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

    $query->join('periods', 'processes.period_id', '=', 'periods.id')->orderBy('periods.year')->orderBy('periods.quarter');

    $this->processes = $query->paginate(6);

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
