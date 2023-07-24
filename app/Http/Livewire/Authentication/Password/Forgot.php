<?php

namespace App\Http\Livewire\Authentication\Password;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Forgot extends Component {

  public $username;
  public $foreign = false;

  protected function rules() {
    return [
      'username' => 'required|string|max:256',
      'foreign' => 'boolean'
    ];
  }

  public function render() {
    return view('livewire.authentication.password.forgot');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function sendRequest() {
    $validated = $this->validate();

    $validated['username'] = !$this->foreign ? $validated['username'] . '@utgz.edu.mx' : $validated['username'];

    $status = Password::sendResetLink([
      'email' => $validated['username']
    ]);

    if ($status === Password::RESET_LINK_SENT) {
      $this->resetForm();

      return $this->emit('reset-requested', __($status));
    } else {
      return $this->addError('status', __($status));
    }
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
