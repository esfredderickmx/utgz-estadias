<?php

namespace App\Http\Livewire\Periods;
use App\Models\Periods;

use Livewire\Component;

class DeletePeriod extends Component
{
    public function render()
    {
        return view('livewire.periods.delete-period');
    }
}
