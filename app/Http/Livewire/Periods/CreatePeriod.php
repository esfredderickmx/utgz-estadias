<?php

namespace App\Http\Livewire\Periods;
use App\Models\Periods;

use Livewire\Component;

class CreatePeriod extends Component
{
    public function render()
    {
        return view('livewire.periods.create-period');
    }
}
