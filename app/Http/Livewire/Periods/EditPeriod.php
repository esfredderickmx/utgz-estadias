<?php

namespace App\Http\Livewire\Periods;

use App\Models\Period;

use Livewire\Component;

class EditPeriod extends Component {

  public Period $period;
  public $initial_state;

  protected function rules() {
    return [
      'period.quarter' => 'required|in:first,second,third',
      'period.year' => 'required|int|digits:4'
    ];
  }

  public function mount() {
    $this->initial_state = $this->period->getAttributes();
  }

  public function render() {
    return view('livewire.periods.edit-period');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatePeriod() {
    $current_state = $this->period->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (empty($differences)) {
      return session()->flash('info', 'Aún no se realizan cambios en la información del periodo.');
    }

    $validated = $this->validate();

    if (Period::where('quarter', $this->period->quarter)->where('year', $this->period->year)->exists()) {
      return session()->flash('info', 'El periodo en el cuatrimestre y año indicados ya existe.');
    }

    $this->period->update($validated);

    $this->initial_state = $this->period->getAttributes();

    $this->resetForm();

    return $this->emit('updated-entity', 'period', $this->period->id, 'La información del periodo ' . ($this->period->quarter === 'first' ? 'Enero - Abril' : ($this->period->quarter === 'second' ? 'Mayo - Agosto' : 'Septiembre - Diciembre')) . ' ' . $this->period->year . ' ha sido actualizada correctamente.');
  }

  public function resetForm() {
    $this->emit('form-reset', 'edit', 'period');
    $this->emit('calendar-reset', $this->initial_state['id'], $this->initial_state['year']);
    $this->period->fill($this->initial_state);
    $this->resetErrorBag();
  }
}
