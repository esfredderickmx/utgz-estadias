<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;
    public $initial_state;

    protected function rules(){
        return [
            'user.first_name' => 'required|string|max:75',
            'user.last_name' => 'required|string|max:75',
            'user.phone' => 'required|numeric|digits:10',
            'user.password' => [
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
              'user.password_confirmation' => 'same:password'
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

    public function updateProfile()
    {
        // $validatedData = $this->validate([
        //     'name' => 'required|string|max:255',
        //     'lastName' => 'required|string|max:255',
        //     'phoneNumber' => 'required|string|max:20',
        //     'password' => 'nullable|string|min:12',
        // ]);


        // session()->flash('message', 'Perfil actualizado correctamente.');

        
    }

    
}

