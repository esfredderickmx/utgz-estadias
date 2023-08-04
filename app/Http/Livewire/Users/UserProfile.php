<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;


class UserProfile extends Component
{
    public User $user;
    public $initial_state;
    public $password;
    public $password_confirmation;
    public $edit_pass=false;

    protected function rules(){
        return [
            'user.first_name' => 'required|string|max:75',
            'user.last_name' => 'required|string|max:75',
            'user.phone' => 'required|numeric|digits:10',
            'edit_pass'=>'boolean',
            'password' => [
              Rule::excludeIf(!$this->edit_pass),
                'required',
                'string',
                'min:12',
                'max:25',
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
              'password_confirmation' => [
                Rule::excludeIf(!$this->edit_pass),
                'same:password'
              ]
            ];
    }
    public function mount()
    {
        $this->user = User::find(Auth::user()->id);
        $this->initial_state = $this->user->getAttributes();

    }

    public function render()
    {
        return view('livewire.users.user-profile');
    }
    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function editProfile()
    {
      $current_state = $this->user->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if($this->edit_pass && !$this->password && !$this->password_confirmation && empty($differences)) {
      return session()->flash('info', 'Aún no se realizan cambios en la información del usuario.');
    }

      $validated=$this->validate();
      if($this->password){
        $validated['password']=$this->password;
      };
      $this->user->update($validated);
      $this->initial_state=$this->user->getAttributes();
      $this->resetForm();
      return $this->emit('updated-profile','La información del perfil ha sido actualizada correctamente.');
    }

    public function resetForm() {
      $this->user->fill($this->initial_state);
      $this->reset("password","password_confirmation","edit_pass");
      $this->resetErrorBag();
    }

    
}

