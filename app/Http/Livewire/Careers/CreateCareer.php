<?php

namespace App\Http\Livewire\Careers;

use App\Models\Area;
use App\Models\Career;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCareer extends Component {
  
  use WithFileUploads;

  private $areas;
  public $area_id;
  public $name;
  public $has_context = false;
  public $context;
  public $grade;
  public $availability;
  public $image;
  public $image_valid;
  
  protected function rules() {
    return [
      'area_id' => 'required|integer|exists:areas,id',
      'name' => 'required|string',
      'has_context' => 'boolean',
      'context' => [
        Rule::excludeIf(!$this->has_context),
        'required',
        'string',
        'nullable'
      ],
      'grade' => 'required|in:technician,higher',
      'availability' => 'required|in:week,weekend,both',
      'image_valid' => 'required|image|max:1024',
      'image' => [
        Rule::excludeIf(!$this->image_valid),
        'required',
        'unique:careers,image'
      ]
    ];
  }

  public function render() {
    $this->areas = Area::query()->orderBy('name')->get();

    return view('livewire.careers.create-career', ['areas' => $this->areas]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatedHasContext() {
    $this->reset('context');
    $this->validateOnly('context');
  }

  public function updatedImageValid() {
    $this->image = uniqid() . '.' . $this->image_valid->getClientOriginalExtension(); // Generar un nombre único para la imagen
    $this->validateOnly('image');
  }

  public function storeCareer() {
    $validated = $this->validate();

    $career = Career::create($validated);
    
    $this->image_valid->storeAs('images/careers', $this->image, 'public');  // Almacenar la imagen en el directorio public/img/careers/

    $this->resetForm();
    
    return $this->emit('created-entity', 'career', 'La carrera de ' . $career->name . ' ha sido registrada correctamente.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
