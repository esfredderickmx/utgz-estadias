<?php

namespace App\Http\Livewire\Areas;

use App\Models\Area;
use Livewire\Component;

class DeleteArea extends Component {

  public Area $area;
  
  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    return view('livewire.areas.delete-area');
  }

  public function destroyArea() {
    $this->area->delete();

    return $this->emit('deleted-entity', 'area', $this->area->id, 'Los datos del área de ' . $this->area->name . ' han sido eliminados correctamente.');
  }

  public function resetForm() {
    $this->resetErrorBag();
  }
}
