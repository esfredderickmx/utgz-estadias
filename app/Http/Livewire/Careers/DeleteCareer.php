<?php

namespace App\Http\Livewire\Careers;

use App\Models\Career;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DeleteCareer extends Component {

  public Career $career;

  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    return view('livewire.careers.delete-career');
  }

  public function destroyCareer() {
    $this->career->delete();
    
    Storage::delete('public/images/careers/' . $this->career->image);

    return $this->emit('deleted-entity', 'career', $this->career->id, 'Los datos de la carrera de ' . $this->career->name . ' ' . $this->career->context ?? '' . 'han sido eliminados correctamente.');
  }

  public function resetForm() {
    $this->resetErrorBag();
  }
}
