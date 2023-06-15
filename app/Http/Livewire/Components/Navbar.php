<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Navbar extends Component {

  protected $listeners = ['refreshUser' => 'render'];

  public function render() {
    return view('livewire.components.navbar');
  }

  public function logout() {
    Auth::logout();

    Session::flush();
    Session::invalidate();
    Session::regenerateToken();

    return redirect()->route('home')->with('logged-out', 'Sesión finalizada correctamente.');
  }
}
