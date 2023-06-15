<?php

namespace App\Http\Livewire\Careers;

use App\Models\Area;
use App\Models\Career;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCareer extends Component {

  use WithFileUploads;

  private $areas;
  public Career $career;
  public $image;
  public $initial_state;
  
  protected function rules() {
    return [
      'career.area_id' => 'required|integer|exists:areas,id',
      'career.name' => 'required|string',
      'career.context' => 'sometimes',
      'career.grade' => 'required|in:technician,higher',
      'career.availability' => 'required|in:week,weekend,both',
      'image' => 'sometimes'
    ];
  }

  public function mount() {
    $this->initial_state = $this->career->getAttributes();
  }

  public function render() {
    $this->areas = Area::all();

    return view('livewire.careers.edit-career', ['areas' => $this->areas]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updateCareer() {
    $current_state = $this->career->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (!empty($differences) || $this->image) {
      $validated = $this->validate();

      $imageName = uniqid() . '.' . $this->image->getClientOriginalExtension(); // Generar un nombre único para la imagen

      if ($this->image) {
        Storage::disk('public')->delete('images/careers/' . $this->career->image);  // Eliminar la imagen existente
  
        $this->image->storeAs('images/careers', $imageName, 'public');  // Almacenar la nueva imagen con el mismo nombre

        $validated['image'] = $imageName;
    
        $this->validateOnly('image');
      }
    } else {
      return session()->flash('info', 'Aún no se realizan cambios.');
    }

    $this->career->update($validated);

    $this->initial_state = $this->career->getAttributes();

    return $this->emit('updated-entity', 'career', $this->career->id, 'La información de la carrera de ' . $this->career->name . ' ha sido actualizada correctamente.');
  }

  public function resetForm() {
    $this->career->fill($this->initial_state);
    $this->resetErrorBag();
  }
}
