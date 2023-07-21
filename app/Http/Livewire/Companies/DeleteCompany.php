<?php

namespace App\Http\Livewire\Companies;

use App\Models\Company;
use Livewire\Component;

class DeleteCompany extends Component {

  public Company $company;

  protected $listeners = ['refresh' => '$refresh'];

  public function render() {
    return view('livewire.companies.delete-company');
  }

  public function destroyCompany() {
    $this->company->delete();

    return $this->emit('deleted-entity', 'company', $this->company->id, 'Los datos de la empresa ' . $this->company->name . ' han sido eliminados correctamente.');
  }

  public function resetForm() {
    $this->resetErrorBag();
  }
}
