<?php

namespace App\Http\Livewire\Authentication;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component {

  public $username;
  public $password;
  public $remember;

  protected function rules() {
    return [
      'username' => 'required',
      'password' => 'required',
      'remember' => ''
    ];
  }

  public function render() {
    return view('livewire.authentication.login');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function showForm() {
    return redirect()->back()->with('openLoginModal', true);
  }

  public function login() {
    $validated = $this->validate();

    $validated['username'] = $validated['username'] . '@utgz.edu.mx';
    $validated['remember'] = $this->remember ? true : false;

    if (Auth::attempt(['email' => $validated['username'], 'password' => $validated['password']], $validated['remember'])) {
      $this->resetForm();

      return $this->emit('logged-in', 'Sesión iniciada correctamente.');
    } else {
      return $this->addError('credentials', 'El usuario y/o la contraseña son incorrectos.');
    }
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
