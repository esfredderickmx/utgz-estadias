<?php

namespace App\Http\Livewire\Areas;

use App\Models\Area;
use Livewire\Component;

class CreateArea extends Component {

  public $icon;
  public $name;
  public $description;

  protected function rules() {
    return [
      'icon' => 'required|string|unique:areas,icon',
      'name' => 'required|string|unique:areas,name',
      'description' => 'required|string'
    ];
  }

  public function render() {
    return view('livewire.areas.create-area');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function storeArea() {
    $validated = $this->validate();

    $area = Area::create($validated);

    $this->resetForm();

    return $this->emit('created-entity', 'area', $area->id, 'El área de ' . $area->name . ' ha sido registrada correctamente.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
