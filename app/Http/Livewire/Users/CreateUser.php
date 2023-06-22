<?php

namespace App\Http\Livewire\Users;

use App\Models\Area;
use App\Models\Career;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateUser extends Component {

  private $areas;
  private $careers;
  public $area_id;
  public $career_id;
  public $first_name;
  public $last_name;
  public $email;
  public $valid_email;
  public $control_number;
  public $phone;
  public $type;
  public $role;

  protected function rules() {
    return [
      'first_name' => 'required|string',
      'last_name' => 'required|string',
      'role' => 'required|in:admin,manager,adviser,student',
      'control_number' => 'required|numeric|unique:users,control_number',
      'phone' => 'required|numeric|min_digits:10|max_digits:10',
      'valid_email' => [
        Rule::excludeIf(!$this->role || $this->role === 'student'),
        'required',
        'email:rfc,dns',
        'unique:users,email'
      ],
      'type' => [
        Rule::excludeIf($this->role !== 'student'),
        'required',
        'in:ordinal,repeater,burned',
        'nullable'
      ],
      'area_id' => [
        Rule::excludeIf($this->role !== 'adviser' && $this->role !== 'manager'),
        'required',
        'integer',
        'exists:areas,id',
        'nullable'
      ],
      'career_id' => [
        Rule::excludeIf($this->role !== 'student'),
        'required',
        'integer',
        'exists:careers,id',
        'nullable'
      ]
    ];
  }

  public function render() {
    $this->areas = Area::all();
    $this->careers = Career::all();

    return view('livewire.users.create-user', ['areas' => $this->areas, 'careers' => $this->careers]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatedRole() {
    $this->reset('email', 'valid_email', 'type', 'area_id', 'career_id');
    $this->validate();
  }

  public function updatedControlNumber() {
    if ($this->role === 'student') {
      $this->valid_email = $this->control_number . '@utgz.edu.mx';
    }
  }

  public function updatedEmail() {
    if ($this->role !== 'student') {
      $this->valid_email = $this->email . '@utgz.edu.mx';
      $this->validateOnly('valid_email');
    }
  }

  public function storeUser() {
    $validated = $this->validate();
    $validated['email'] = $this->valid_email;
    $validated['password'] = 'UTgz123*';

    $user = User::create($validated);

    $this->resetForm();

    return $this->emit('created-entity', 'user', $user->id, 'El usuario llamado ' . strtok($user->first_name, ' ') . ' ' . strtok($user->last_name, ' ') . ' ha sido registrado correctamente.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
