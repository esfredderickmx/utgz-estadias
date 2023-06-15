<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
      'start',
      'end',
      'year'
    ];

    public function processes(): HasMany {
      return $this->hasMany(Process::class);
    }
}
