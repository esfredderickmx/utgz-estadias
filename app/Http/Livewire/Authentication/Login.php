<?php

namespace App\Http\Livewire\Authentication;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component {

  public $username;
  public $foreign = false;
  public $password;
  public $remember = false;

  protected function rules() {
    return [
      'username' => 'required|string|max:256',
      'foreign' => 'boolean',
      'password' => 'required|string|max:25',
      'remember' => 'boolean'
    ];
  }

  public function render() {
    return view('livewire.authentication.login');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function showForm() {
    return redirect()->route('home')->with('openLoginModal', true);
  }

  public function login() {
    $validated = $this->validate();

    $validated['username'] = !$this->foreign ? $validated['username'] . '@utgz.edu.mx' : $validated['username'];

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
