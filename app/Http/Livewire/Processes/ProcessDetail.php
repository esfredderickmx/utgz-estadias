<?php

namespace App\Http\Livewire\Processes;

use App\Models\Comment;
use App\Models\Process;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProcessDetail extends Component {

  private $reviews;
  private $comments;
  public Process $process;
  public $message;

  protected $listeners = ['refresh' => '$refresh'];

  protected function rules() {
    return [
      'message' => 'required|string|max:255'
    ];
  }

  public function mount($process) {
    if (Auth::user()->role === 'student') {
      // Verificar si el usuario está vinculado al proceso como estudiante
      if ($process->student->first()->id !== Auth::user()->id) {
        return redirect('processes'); // Acceso denegado si el usuario no está vinculado al proceso como estudiante
      }
    }
    if (Auth::user()->role === 'adviser') {
      if ($process->adviser->first()->id !== Auth::user()->id) {
        return redirect('processes');
      }
    }
    if (Auth::user()->role === 'manager') {
      if ($process->student->first()->career->area !== Auth::user()->area) {
        return redirect('processes');
      }
    }

    $this->process = $process;
  }

  public function render() {
    $query = Review::query()->where('process_id', $this->process->id);

    $query->orderBy('number');

    $this->reviews = $query->get();
    $this->comments = Comment::query()->where('process_id', $this->process->id)->get();

    return view('livewire.processes.process-detail', ['reviews' => $this->reviews, 'comments' => $this->comments]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }


  public function addComment() {
    $validated = $this->validate();
    $validated['user_id'] = Auth::user()->id;
    $validated['process_id'] = $this->process->id;

    // Obtenemos la fecha y hora actual usando Carbon
    $now = Carbon::now();

    // Asignamos la fecha actual en el formato 'Y-m-d' (compatible con el tipo de columna date de MySQL)
    $validated['date'] = $now->toDateString();
    // Asignamos la hora actual en el formato 'H:i:s' (compatible con el tipo de columna time de MySQL)
    $validated['time'] = $now->toTimeString();

    Comment::create($validated);

    $this->resetForm();

    return $this->emit('comment-added', 'Comentario agregado correctamente.');
  }

  public function resetForm() {
    $this->reset('message');
    $this->resetErrorBag();
  }
}
