<?php

namespace App\Http\Livewire\Companies;

use App\Models\Company;
use Livewire\Component;

class EditCompany extends Component {

  public Company $company;
  public $initial_state;

  protected function rules() {
    return [
      'company.name' => 'required|string|max:75|unique:companies,name,' . $this->company->id,
      'company.email' => 'required|email:rfc,dns|unique:companies,email,' . $this->company->id,
      'company.phone' => 'required|numeric|digits:10|unique:companies,phone,' . $this->company->id,
      'company.street' => 'required|string|max:50',
      'company.number' => 'required|string|max:10',
      'company.division' => 'required|string|max:50',
      'company.zip' => 'required|numeric|digits:5',
      'company.city' => 'required|string|max:50',
      'company.state' => 'required|string|max:50',
    ];
  }

  public function mount() {
    $this->initial_state = $this->company->getAttributes();
  }

  public function render() {
    return view('livewire.companies.edit-company');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updateCompany() {
    $current_state = $this->company->getAttributes();
    $differences = array_diff_assoc($this->initial_state, $current_state);

    if (empty($differences)) {
      return session()->flash('info', 'Aún no se realizan cambios en la información de la empresa.');
    }

    $validated = $this->validate();

    $this->company->update($validated);

    $this->initial_state = $this->company->getAttributes();

    $this->resetForm();

    return $this->emit('updated-entity', 'company', $this->company->id, 'La información de la empresa ' . $this->company->name . ' ha sido actualizada correctamente.');
  }

  public function resetForm() {
    $this->company->fill($this->initial_state);
    $this->resetErrorBag();
  }
}
