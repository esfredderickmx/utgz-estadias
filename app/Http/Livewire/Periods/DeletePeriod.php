<?php

namespace App\Http\Livewire\Periods;

use App\Models\Period;

use Livewire\Component;

class DeletePeriod extends Component {

  public Period $period;

  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    return view('livewire.periods.delete-period');
  }

  public function destroyPeriod() {
    $this->period->delete();

    return $this->emit('deleted-entity', 'period', $this->period->id, 'Los datos del periodo ' . ($this->period->quarter === 'first' ? 'Enero - Abril' : ($this->period->quarter === 'second' ? 'Mayo - Agosto' : 'Septiembre - Diciembre')) . ' ' . $this->period->year . ' han sido eliminados correctamente.');
  }

  public function resetForm() {
    $this->resetErrorBag();
  }
}
