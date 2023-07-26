<?php

namespace App\Http\Livewire\Periods;

use App\Models\Period;

use Livewire\Component;

class CreatePeriod extends Component {

  public $quarter;
  public $year;

  protected function rules() {
    return [
      'quarter' => 'required|in:first,second,third',
      'year' => 'required|int|digits:4'
    ];
  }

  public function render() {
    return view('livewire.periods.create-period');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function storePeriod() {
    $validated = $this->validate();

    if (Period::where('quarter', $this->quarter)->where('year', $this->year)->exists()) {
      return session()->flash('info', 'El periodo en el cuatrimestre y año indicados ya existe.');
    }

    $period = Period::create($validated);

    $this->resetForm();

    return $this->emit('created-entity', 'period', 'El periodo ' . ($period->quarter === 'first' ? 'Enero - Abril' : ($period->quarter === 'second' ? 'Mayo - Agosto' : 'Septiembre - Diciembre')) . ' ' . $period->year . ' ha sido registrado correctamente.');
  }

  public function resetForm() {
    $this->emit('form-reset', 'create', 'period');
    $this->emit('calendar-reset', null, null);
    $this->reset();
    $this->resetErrorBag();
  }
}
