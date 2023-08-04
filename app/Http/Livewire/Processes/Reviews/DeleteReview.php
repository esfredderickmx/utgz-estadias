<?php

namespace App\Http\Livewire\Processes\Reviews;

use App\Models\Review;
use Livewire\Component;

class DeleteReview extends Component {

  public Review $review;

  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    return view('livewire.processes.reviews.delete-review');
  }

  public function destroyReview() {
    $this->review->delete();

    return $this->emit('deleted-entity', 'review', $this->review->id, 'Los datos de la revisión número ' . $this->review->number . ' han sido eliminados correctamente.');
  }

  public function resetForm() {
    $this->resetErrorBag();
  }
}
