<?php

namespace App\Http\Livewire\Processes\Reviews;

use App\Models\Process;
use App\Models\Review;
use Livewire\Component;

class CreateReview extends Component {

  public Process $process;
  public $process_id;
  public $number;
  public $instructions;
  public $status;
  public $limit_date;

  protected function rules() {
    return [
      'process_id' => 'required|integer|exists:processes,id',
      'number' => 'required|integer',
      'instructions' => 'required|string|max:500',
      'status' => 'required|in:pending,reviewing,rejected,approved',
      'limit_date' => 'required|date_format:Y-m-d'
    ];
  }

  public function mount($process) {
    $this->process = $process;
    $this->number = Review::where('process_id', $this->process->id)->max('number') + 1;
  }

  public function render() {
    return view('livewire.processes.reviews.create-review');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function storeReview() {
    $this->process_id = $this->process->id;
    $validated = $this->validate();

    if (Review::where('number', $this->number)->where('process_id', $this->process_id)->exists()) {
      return session()->flash('info', 'La revisión número ' . $this->number . ' ya existe en este proceso.');
    }

    $review = Review::create($validated);

    $this->resetForm();

    return $this->emit('created-entity', 'review', 'la revisión número ' . $review->number . ' ha sido registrada correctamente.');
  }

  public function resetForm() {
    $this->number = Review::where('process_id', $this->process->id)->max('number') + 1;
    $this->emit('form-reset', 'create', 'review');
    $this->emit('calendar-reset', null, null);
    $this->reset("instructions", "status", "limit_date");
    $this->resetErrorBag();
  }
}
