<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
      'area_id',
      'name',
      'context',
      'grade',
      'availability',
      'image'
    ];

    public function area(): BelongsTo {
      return $this->belongsTo(Area::class);
    }

    public function users(): HasMany {
      return $this->hasMany(User::class);
    }
}
