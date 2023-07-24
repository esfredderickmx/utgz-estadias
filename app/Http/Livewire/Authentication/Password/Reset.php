<?php

namespace App\Http\Livewire\Authentication\Password;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Reset extends Component {

  public $token;
  public $username;
  public $foreign = false;
  public $password;
  public $password_confirmation;

  protected function rules() {
    return [
      'token' => 'required',
      'username' => 'required|string|max:256',
      'foreign' => 'boolean',
      'password' => [
        'required',
        'string',
        'min:12',
        'max:25',
        'not_in:' . $this->username,
        function ($attribute, $value, $fail) {
          if (!preg_match('/[a-z]/', $value)) {
            $fail('El campo :attribute debe contener al menos una letra minúscula.');
          } elseif (!preg_match('/[A-Z]/', $value)) {
            $fail('El campo :attribute debe contener al menos una letra mayúscula.');
          } elseif (!preg_match('/\d/', $value)) {
            $fail('El campo :attribute debe contener al menos un número.');
          } elseif (!preg_match('/[_\W]/', $value)) {
            $fail('El campo :attribute debe contener al menos un carácter especial.');
          }
        },
      ],
      'password_confirmation' => 'same:password'
    ];
  }

  public function mount($token, $username) {
    $this->token = $token;
    $this->username = $username;
    
    if (strpos($this->username, '@utgz.edu.mx') !== false) {
        $this->foreign = false;
    } else {
        $this->foreign = true;
    }
  }

  public function render() {
    return view('livewire.authentication.password.reset');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function showForm() {
    return redirect()->route('home')->with([
      'token' => request('token', null),
      'username' => request('email'),
      'openResetModal' => true
    ]);
  }

  public function resetPassword() {
    $validated = $this->validate();

    $status = Password::reset(
      [
        'email' => $validated['username'],
        'password' => $validated['password'],
        'password_confirmation' => $validated['password_confirmation'],
        'token' => $validated['token']
      ],
      function ($user, $password) {
        $user->forceFill([
          'password' => $password,
        ])->save();

        event(new PasswordReset($user));
      }
    );

    if ($status === Password::PASSWORD_RESET) {
      $this->resetForm();

      return $this->emit('password-reset', __($status));
    } else {
      return $this->addError('status', __($status));
    }
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
