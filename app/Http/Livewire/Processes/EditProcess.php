<?php

namespace App\Http\Livewire\Processes;

use App\Models\Company;
use App\Models\Period;
use App\Models\Process;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditProcess extends Component {

  private $periods;
  private $companies;
  private $students;
  private $advisers;
  public Process $process;
  public $student_id;
  public $adviser_id;
  public $initial_state;
  public $initial_student;
  public $initial_adviser;
  public $attempt_count;
  public $active_process;

  protected function rules() {
    return [
      'process.period_id' => 'required|exists:periods,id',
      'process.company_id' => 'required|exists:companies,id',
      'student_id' => 'required|exists:users,id',
      'adviser_id' => 'required|exists:users,id',
      'process.attempt' => [
        Rule::excludeIf(!$this->process->student_id),
        'required',
        'in:one,two,three,no_more'
      ],
      'process.type' => [
        Rule::excludeIf(!$this->process->student_id),
        'required',
        'in:technician,higher'
      ]
    ];
  }

  public function mount() {
    $this->initial_student =$this->student_id = $this->process->student->first()->id;
    $this->initial_adviser = $this->adviser_id = $this->process->adviser->first()->id;
    $this->initial_state = $this->process->getAttributes();
  }

  public function render() {
    $this->periods = Period::query()->orderBy('year')->orderBy('quarter')->get();
    $this->companies = Company::query()->orderBy('name')->get();
    $this->students = User::query()->where('role', 'student')->orderBy('code')->get();
    $this->advisers = User::query()->where('role', 'adviser')->orderBy('first_name')->orderBy('last_name')->get();
    
    return view('livewire.processes.edit-process', [
      'periods' => $this->periods,
      'companies' => $this->companies,
      'students' => $this->students,
      'advisers' => $this->advisers
    ]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatedStudentId() {
    // Obtenemos el estudiante seleccionado
    $student = User::find($this->student_id);

    // Verificamos si el estudiante existe y tiene una carrera relacionada
    if ($student && $student->career) {
      // Obtenemos el tipo de la carrera del estudiante
      $grade = $student->career->grade;

      // Asignamos el valor de 'type' basado en el tipo de la carrera del estudiante
      $this->process->type = ($grade === 'technician') ? 'technician' : 'higher';

      // Verificamos si hay algún proceso en curso (status 'pending' o 'developing') para el estudiante
      $this->active_process = $student->processes()->where('type', $this->process->type)->whereIn('status', ['pending', 'developing'])->exists();
      // Contamos la cantidad de procesos que el estudiante ha realizado con el mismo 'type'
      $this->attempt_count = $student->processes()->where('type', $this->process->type)->where('status', 'unapproved')->count();

      // Asignamos el valor de 'attempt' basado en la cantidad de intentos
      if ($this->attempt_count < 1) {
        $this->process->attempt = 'one';
      } elseif ($this->attempt_count >= 1 && $this->attempt_count < 2) {
        $this->process->attempt = 'two';
      } elseif ($this->attempt_count >= 2 && $this->attempt_count < 3) {
        $this->process->attempt = 'three';
      } elseif ($this->attempt_count === 3) {
        $this->process->attempt = 'no_more';
      }
    }
  }

  public function updateProcess() {
    $current_state = $this->process->getAttributes();
    $id_differences = $this->student_id !== $this->initial_student || $this->adviser_id !== $this->initial_adviser;
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (empty($differences) && !$id_differences) {
      return session()->flash('info', 'Aún no se realizan cambios en la información del proceso.');
    }

    if ($this->active_process) {
      return $this->addError('active_process', 'El estudiante seleccionado ya tiene un proceso en curso.');
    }

    if ($this->attempt_count === 3) {
      return $this->addError('burned_student', 'El estudiante seleccionado ya no tiene derecho a más procesos.');
    }

    $validated = $this->validate();

    $this->process->update($validated);
    $this->process->users()->sync([$this->student_id, $this->adviser_id]);

    $this->initial_state = $this->process->getAttributes();
    $this->initial_student =$this->student_id;
    $this->initial_adviser = $this->adviser_id;

    $this->resetForm();

    return $this->emit('updated-entity', 'process', $this->process->id, 'La información del proceso de ' . strtok($this->process->student->first()->first_name, ' ') . ' ' . strtok($this->process->student->first()->last_name, ' ') . ' ha sido actualizada correctamente.');
  }

  public function resetForm() {
    $this->process->fill($this->initial_state);
    $this->student_id = $this->initial_student;
    $this->adviser_id = $this->initial_adviser;
    $this->resetErrorBag();
  }
}
