<?php

namespace App\Http\Livewire\Companies;

use App\Models\Company;
use Livewire\Component;

class CreateCompany extends Component {

  public $name;
  public $email;
  public $phone;
  public $street;
  public $number;
  public $division;
  public $city;
  public $state;
  public $zip;

  protected function rules() {
    return [
      'name' => 'required|string|max:75|unique:companies,name',
      'email' => 'required|email:rfc,dns|unique:companies,email',
      'phone' => 'required|numeric|digits:10|unique:companies,phone',
      'street' => 'required|string|max:50',
      'number' => 'required|string|max:10',
      'division' => 'required|string|max:50',
      'zip' => 'required|numeric|digits:5',
      'city' => 'required|string|max:50',
      'state' => 'required|string|max:50',
    ];
  }

  public function render() {
    return view('livewire.companies.create-company');
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function storeCompany() {
    $validated = $this->validate();;
    
    $company = Company::create($validated);

    $this->resetForm();

    return $this->emit('created-entity', 'company', 'La empresa ' . $company->name . ' ha sido registrada correctamente.');
  }

  public function resetForm() {
    $this->reset();
    $this->resetErrorBag();
  }
}
