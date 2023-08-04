<?php

namespace App\Http\Livewire\Processes\Reviews;

use App\Models\Review;
use Livewire\Component;

class EditReview extends Component {

  public Review $review;
  public $initial_state;

  protected function rules() {
    return [
      'review.number' => 'required|integer',
      'review.instructions' => 'required|string|max:500',
      'review.status' => 'required|in:pending,reviewing,rejected,approved',
      'review.limit_date' => 'required|date_format:Y-m-d'
    ];
  }

  public function mount() {
    $this->initial_state = $this->review->getAttributes();
  }

  public function render() {
    return view('livewire.processes.reviews.edit-review');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updateReview() {
    $current_state = $this->review->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (empty($differences)) {
      return session()->flash('info', 'Aún no se realizan cambios en la información de la revisión.');
    }

    $validated = $this->validate();

    $this->review->update($validated);

    $this->initial_state = $this->review->getAttributes();

    $this->resetForm();

    return $this->emit('updated-entity', 'review', $this->review->id, 'La información de la revisión número ' . $this->review->number . ' ha sido actualizada correctamente.');
  }

  public function resetForm() {
    $this->emit('form-reset', 'edit', 'review');
    $this->emit('calendar-reset', $this->initial_state['id'], $this->initial_state['limit_date']);
    $this->review->fill($this->initial_state);
    $this->resetErrorBag();
  }
}
