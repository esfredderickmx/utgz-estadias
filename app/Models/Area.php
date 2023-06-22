<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'icon',
      'description'
    ];

    public function careers(): HasMany {
      return $this->hasMany(Career::class);
    }

    public function users(): HasMany {
      return $this->hasMany(User::class);
    }
}
