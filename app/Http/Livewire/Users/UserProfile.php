<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;

// class UserProfile extends Component
// {
//     public function render()
//     {
//         return view('livewire.users.user-profile');
//     }
// }

class UserProfile extends Component
{
    public $name;
    public $lastName;
    public $phoneNumber;
    public $password;

    public function mount()
    {
        $this->name = 'Nombre actual del usuario';
        $this->lastName = 'Apellido actual del usuario';
        $this->phoneNumber = 'Número de teléfono actual';
        $this->password = ''; 
    }

    public function updateProfile()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'password' => 'nullable|string|min:12',
        ]);


        session()->flash('message', 'Perfil actualizado correctamente.');

        
        // return redirect()->to('/dashboard');
    }

    public function render()
    {
        return view('livewire.users.user-profile');
    }
}

