<?php

namespace App\Http\Livewire\Areas;

use App\Models\Area;
use Livewire\Component;

class EditArea extends Component {

  public Area $area;
  public $initial_state;

  protected function rules() {
    return [
      'area.icon' => 'required|string|unique:areas,icon,' . $this->area->id,
      'area.name' => 'required|string|unique:areas,name,' . $this->area->id,
      'area.description' => 'required|string'
    ];
  }
  protected $listeners = ['icon-selection' => 'setIcon'];

  public function mount() {
    $this->initial_state = $this->area->getAttributes();
  }

  public function render() {
    return view('livewire.areas.edit-area');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updateArea() {
    $current_state = $this->area->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (empty($differences)) {
      return session()->flash('info', 'Aún no se realizan cambios en la información del área.');
    }

    $validated = $this->validate();

    $this->area->update($validated);

    $this->initial_state = $this->area->getAttributes();

    $this->resetForm();

    return $this->emit('updated-entity', 'area', $this->area->id, 'La información del área de ' . $this->area->name . ' ha sido actualizada correctamente.');
  }

  public function setIcon($selection) {
    $this->area->icon = $selection;
    $this->validateOnly('area.icon');
  }

  public function resetForm() {
    $this->area->fill($this->initial_state);
    $this->resetErrorBag();
  }
}
