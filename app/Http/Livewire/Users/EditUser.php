<?php

namespace App\Http\Livewire\Users;

use App\Models\Area;
use App\Models\Career;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditUser extends Component {

  private $areas;
  private $careers;
  public User $user;
  public $help_email;
  public $initial_state;

  protected function rules() {
    return [
      'user.first_name' => 'required|string',
      'user.last_name' => 'required|string',
      'user.role' => 'required|in:admin,manager,adviser,student',
      'user.code' => 'required|numeric|unique:users,code,' . $this->user->id,
      'user.phone' => 'required|numeric|min_digits:10|max_digits:10',
      'user.email' => [
        Rule::excludeIf(!$this->user->role || $this->user->role === 'student'),
        'required',
        'email:rfc,dns',
        Rule::unique('users', 'email')->ignore($this->user->id)
      ],
      'user.type' => [
        Rule::excludeIf($this->user->role !== 'student'),
        'required',
        'in:ordinal,repeater,burned',
        'nullable'
      ],
      'user.area_id' => [
        Rule::excludeIf($this->user->role !== 'adviser' && $this->user->role !== 'manager'),
        'required',
        'integer',
        'exists:areas,id',
        'nullable'
      ],
      'user.career_id' => [
        Rule::excludeIf($this->user->role !== 'student'),
        'required',
        'integer',
        'exists:careers,id',
        'nullable'
      ]
    ];
  }

  public function mount() {
    $this->help_email = strtok($this->user->email, '@');
    $this->initial_state = $this->user->getAttributes();
  }

  public function render() {
    $this->areas = Area::query()->orderBy('name')->get();
    $this->careers = Career::query()->orderBy('name')->get();

    return view('livewire.users.edit-user', ['areas' => $this->areas, 'careers' => $this->careers]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatedUserRole() {
    $this->help_email = $this->user->email = $this->user->type = $this->user->area_id = $this->user->career_id = null;
    $this->updatedUserCode();
    $this->validate([
      'user.email' => [
        Rule::excludeIf(!$this->user->role || $this->user->role === 'student'),
        'required',
        'email:rfc,dns',
        Rule::unique('users', 'email')->ignore($this->user->id)
      ],
      'user.type' => [
        Rule::excludeIf($this->user->role !== 'student'),
        'required',
        'in:ordinal,repeater,burned',
        'nullable'
      ],
      'user.area_id' => [
        Rule::excludeIf($this->user->role !== 'adviser' && $this->user->role !== 'manager'),
        'required',
        'integer',
        'exists:areas,id',
        'nullable'
      ],
      'user.career_id' => [
        Rule::excludeIf($this->user->role !== 'student'),
        'required',
        'integer',
        'exists:careers,id',
        'nullable'
      ]
    ]);
    $this->updatedHelpEmail();
  }

  public function updatedUserCode() {
    if ($this->user->role === 'student') {
      $this->user->email = $this->user->code . '@utgz.edu.mx';
    }
  }

  public function updatedHelpEmail() {
    if ($this->user->role !== 'student') {
      $this->user->email = $this->help_email . '@utgz.edu.mx';
      $this->validateOnly('user.email');
    }
  }

  public function updateUser() {
    if (Auth::user()->id === $this->user->id) {
      return session()->flash('warning', 'No se puede actualizar la información del usuario autenticado.');
    }

    $current_state = $this->user->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (empty($differences)) {
      return session()->flash('info', 'Aún no se realizan cambios en la información del usuario.');
    }

    $validated = $this->validate();

    $this->user->update($validated);

    $this->initial_state = $this->user->getAttributes();

    $this->resetForm();

    return $this->emit('updated-entity', 'user', $this->user->id, 'La información del usuario llamado ' . strtok($this->user->first_name, ' ') . ' ' . strtok($this->user->last_name, ' ') . ' ha sido actualizada correctamente.');
  }

  public function resetForm() {
    $this->user->fill($this->initial_state);
    $this->help_email = strtok($this->user->email, '@');
    $this->resetErrorBag();
  }
}
