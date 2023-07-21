<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'email',
      'phone',
      'street',
      'number',
      'zip',
      'division',
      'city',
      'state'
    ];

    public function processes(): HasMany {
      return $this->hasMany(Process::class);
    }
}
