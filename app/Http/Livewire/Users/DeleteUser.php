<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteUser extends Component {

  public User $user;

  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    return view('livewire.users.delete-user');
  }

  public function destroyUser() {
    if (Auth::user()->id === $this->user->id) {
      return session()->flash('warning', 'No se pueden eliminar los datos del usuario autenticado.');
    }

    $this->user->delete();

    return $this->emit('deleted-entity', 'user', $this->user->id, 'Los datos del usuario llamado ' . strtok($this->user->first_name, ' ') . ' ' . strtok($this->user->last_name, ' ') . ' han sido eliminados correctamente.');
  }

  public function resetForm() {
    $this->resetErrorBag();
  }
}
