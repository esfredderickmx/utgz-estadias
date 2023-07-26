<?php

namespace App\Http\Livewire\Careers;

use App\Models\Area;
use App\Models\Career;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCareer extends Component {

  use WithFileUploads;

  private $areas;
  public Career $career;
  public $has_context = false;
  public $has_image = false;
  public $image_valid;
  public $initial_state;
  
  protected function rules() {
    return [
      'career.area_id' => 'required|integer|exists:areas,id',
      'career.name' => 'required|string|max:50',
      'career.context' => [
        Rule::excludeIf(!$this->has_context),
        'required',
        'string',
        'max:50'
      ],
      'has_context' => 'boolean',
      'career.grade' => 'required|in:technician,higher',
      'career.availability' => 'required|in:week,weekend,both',
      'has_image' => 'boolean',
      'image_valid' => [
        Rule::excludeIf(!$this->has_image),
        'required',
        'image',
        'max:128'
      ],
      'career.image' => [
        Rule::excludeIf(!$this->has_image || !$this->image_valid),
        'required',
        'string',
        'unique:careers,image'
      ]
    ];
  }

  public function mount() {
    $this->initial_state = $this->career->getAttributes();
    $this->has_context = $this->career->context ? true : false;
  }

  public function render() {
    $this->areas = Area::query()->orderBy('name')->get();

    return view('livewire.careers.edit-career', ['areas' => $this->areas]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatedHasContext() {
    $this->career->context = null;
    $this->validateOnly('career.context');
  }

  public function updatedHasImage() {
    $this->image_valid = null;
    $this->validateOnly('image_valid');
  }

  public function updatedImageValid() {
    $this->career->image = uniqid() . '.' . $this->image_valid->getClientOriginalExtension(); // Generar un nombre único para la imagen
    $this->validateOnly('career.image');
  }

  public function updateCareer() {
    $current_state = $this->career->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (empty($differences)) {
      return session()->flash('info', 'Aún no se realizan cambios en la información de la carrera.');
    }

    $validated = $this->validate();

    if ($this->has_image) {
      Storage::delete('public/images/careers/' . $this->initial_state['image']);  // Eliminar la imagen existente

      $this->image_valid->storeAs('images/careers', $this->career->image, 'public');  // Almacenar la nueva imagen con el mismo nombre
    }

    $this->career->update($validated);

    $this->initial_state = $this->career->getAttributes();

    $this->resetForm();

    return $this->emit('updated-entity', 'career', $this->career->id, 'La información de la carrera de ' . $this->career->name . ' ha sido actualizada correctamente.');
  }

  public function resetForm() {
    $this->career->fill($this->initial_state);
    $this->has_context = $this->initial_state['context'] ? true : false;
    $this->reset('has_image', 'image_valid');
    $this->resetErrorBag();
  }
}
