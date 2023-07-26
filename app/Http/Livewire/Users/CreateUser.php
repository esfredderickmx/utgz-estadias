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
  public $help_email;
  public $email;
  public $code;
  public $phone;
  public $type;
  public $role;

  protected function rules() {
    return [
      'first_name' => 'required|string|max:75',
      'last_name' => 'required|string|max:75',
      'role' => 'required|in:admin,manager,adviser,student',
      'code' => 'required|numeric|max_digits:8|unique:users,code',
      'phone' => 'required|numeric|digits:10',
      'email' => [
        Rule::excludeIf(!$this->role || $this->role==='student'),
        'required',
        'email:rfc,dns',
        'unique:users,email'
      ],
      'type' => [
        Rule::excludeIf($this->role !== 'student'),
        'required',
        'in:ordinal,repeater,burned'
      ],
      'area_id' => [
        Rule::excludeIf($this->role !== 'adviser' && $this->role !== 'manager'),
        'required',
        'integer',
        'exists:areas,id'
      ],
      'career_id' => [
        Rule::excludeIf($this->role !== 'student'),
        'required',
        'integer',
        'exists:careers,id'
      ]
    ];
  }

  public function render() {
    $this->areas = Area::query()->orderBy('name')->get();
    $this->careers = Career::query()->orderBy('name')->get();

    return view('livewire.users.create-user', ['areas' => $this->areas, 'careers' => $this->careers]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatedRole() {
    $this->reset('help_email', 'email', 'type', 'area_id', 'career_id');
    $this->updatedCode();
    $this->validate([
      'email' => [
        Rule::excludeIf(!$this->role || $this->role==='student'),
        'required',
        'email:rfc,dns',
        'unique:users,email'
      ],
      'type' => [
        Rule::excludeIf($this->role !== 'student'),
        'required',
        'in:ordinal,repeater,burned'
      ],
      'area_id' => [
        Rule::excludeIf($this->role !== 'adviser' && $this->role !== 'manager'),
        'required',
        'integer',
        'exists:areas,id'
      ],
      'career_id' => [
        Rule::excludeIf($this->role !== 'student'),
        'required',
        'integer',
        'exists:careers,id'
      ]
    ]);
    $this->updatedHelpEmail();
  }

  public function updatedCode() {
    if ($this->role === 'student') {
      $this->email = $this->code . '@utgz.edu.mx';
    }
  }

  public function updatedHelpEmail() {
    if ($this->role !== 'student') {
      $this->email = $this->help_email . '@utgz.edu.mx';
      $this->validateOnly('email');
    }
  }

  public function storeUser() {
    $validated = $this->validate();
    $validated['email'] = $this->email;
    $validated['password'] = 'UTgz123*';
    
    $user = User::create($validated);

    $this->resetForm();

    return $this->emit('created-entity', 'user', 'El usuario llamado ' . strtok($user->first_name, ' ') . ' ' . strtok($user->last_name, ' ') . ' ha sido registrado correctamente.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
