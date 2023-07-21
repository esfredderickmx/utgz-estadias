<?php

namespace App\Http\Livewire\Processes;

use App\Models\Process;
use Livewire\Component;

class DeleteProcess extends Component {

  public Process $process;

  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    return view('livewire.processes.delete-process');
  }

  public function destroyProcess() {
    $this->process->delete();
    $this->process->users()->detach();

    return $this->emit('deleted-entity', 'process', $this->process->id, 'Los datos del proceso de ' . strtok($this->process->first_name, ' ') . ' ' . strtok($this->process->last_name, ' ') . ' han sido eliminados correctamente.');
  }

  public function resetForm() {
    $this->resetErrorBag();
  }
}
