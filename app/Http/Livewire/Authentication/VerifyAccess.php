<?php

namespace App\Http\Livewire\Authentication;

use Illuminate\Validation\Rule;
use Livewire\Component;

class VerifyAccess extends Component {

  public $username;

  protected $messages = [
    'username.exists' => 'Este correo no cuenta con acceso a la plataforma de estadías.'
  ];

  protected function rules() {
    return [
      'username' => [
        'required',
        'string',
        'max:64',
        Rule::exists('users', 'code')->where(function ($query) {
          return $query->where('role', 'student');
        })
      ]
    ];
  }

  public function render() {
    return view('livewire.authentication.verify-access');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function verifyAccess() {
    $this->validate();

    return session()->flash('success', 'Este correo ya cuenta con acceso a la plataforma de estadías.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
