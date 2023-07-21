<?php

namespace App\Http\Livewire\Processes;

use App\Models\Company;
use App\Models\Period;
use App\Models\Process;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateProcess extends Component {

  private $periods;
  private $companies;
  private $students;
  private $advisers;
  public $period_id;
  public $company_id;
  public $student_id;
  public $adviser_id;
  public $attempt;
  public $type;
  public $status;
  public $attempt_count;
  public $active_process;

  protected function rules() {
    return [
      'period_id' => 'required|exists:periods,id',
      'company_id' => 'required|exists:companies,id',
      'student_id' => 'required|exists:users,id',
      'adviser_id' => 'required|exists:users,id',
      'attempt' => [
        Rule::excludeIf(!$this->student_id),
        'required',
        'in:one,two,three,no_more'
      ],
      'type' => [
        Rule::excludeIf(!$this->student_id),
        'required',
        'in:technician,higher'
      ]
    ];
  }

  public function render() {
    $this->periods = Period::query()->orderBy('year')->orderBy('quarter')->get();
    $this->companies = Company::query()->orderBy('name')->get();
    $this->students = User::query()->where('role', 'student')->orderBy('code')->get();
    $this->advisers = User::query()->where('role', 'adviser')->orderBy('first_name')->orderBy('last_name')->get();

    return view('livewire.processes.create-process', [
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
      $this->type = ($grade === 'technician') ? 'technician' : 'higher';

      // Verificamos si hay algún proceso en curso (status 'pending' o 'developing') para el estudiante
      $this->active_process = $student->processes()->where('type', $this->type)->whereIn('status', ['pending', 'developing'])->exists();
      // Contamos la cantidad de procesos que el estudiante ha realizado con el mismo 'type'
      $this->attempt_count = $student->processes()->where('type', $this->type)->where('status', 'unapproved')->count();

      // Asignamos el valor de 'attempt' basado en la cantidad de intentos
      if ($this->attempt_count < 1) {
        $this->attempt = 'one';
      } elseif ($this->attempt_count >= 1 && $this->attempt_count < 2) {
        $this->attempt = 'two';
      } elseif ($this->attempt_count >= 2 && $this->attempt_count < 3) {
        $this->attempt = 'three';
      } elseif ($this->attempt_count === 3) {
        $this->attempt = 'no_more';
      }
    }
  }

  public function storeProcess() {
    if ($this->active_process) {
      return $this->addError('active_process', 'El estudiante seleccionado ya tiene un proceso en curso.');
    }

    if ($this->attempt_count === 3) {
      return $this->addError('burned_student', 'El estudiante seleccionado ya no tiene derecho a más procesos.');
    }
    
    $validated = $this->validate();

    $process = Process::create($validated);
    $process->users()->sync([$this->student_id, $this->adviser_id]);

    $this->resetForm();

    return $this->emit('created-entity', 'process', 'El proceso de ' . strtok($process->student->first()->first_name, ' ') . ' ' . strtok($process->student->first()->last_name, ' ') . ' ha sido registrado correctamente.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
