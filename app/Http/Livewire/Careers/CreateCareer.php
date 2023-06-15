<?php

namespace App\Http\Livewire\Careers;

use App\Models\Area;
use App\Models\Career;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCareer extends Component {
  
  use WithFileUploads;

  private $areas;
  public $area_id;
  public $name;
  public $context;
  public $grade;
  public $availability;
  public $image;
  
  protected function rules() {
    return [
      'area_id' => 'required|integer|exists:areas,id',
      'name' => 'required|string',
      'context' => 'sometimes|string|nullable',
      'grade' => 'required|in:technician,higher',
      'availability' => 'required|in:week,weekend,both',
      'image' => 'required|image|max:1024|unique:careers,image'
    ];
  }

  public function render() {
    $this->areas = Area::all();

    return view('livewire.careers.create-career', ['areas' => $this->areas]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function storeCareer() {
    $validated = $this->validate();

    $imageName = uniqid() . '.' . $this->image->getClientOriginalExtension(); // Generar un nombre único para la imagen

    $this->image->storeAs('images/careers', $imageName, 'public');  // Almacenar la imagen en el directorio public/img/careers/

    $validated['image'] = $imageName;

    $this->validateOnly('image');

    $career = Career::create($validated);

    $this->resetForm();
    
    return $this->emit('created-entity', 'career', $career->id, 'La carrera de ' . $career->name . ' ha sido registrada correctamente.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
