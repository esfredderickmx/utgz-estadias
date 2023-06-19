<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
      'period_id',
      'kind',
      'status'
    ];

    public function period(): BelongsTo {
      return $this->belongsTo(Period::class);
    }

    public function reviews(): HasMany {
      return $this->hasMany(Review::class);
    }

    public function users(): BelongsToMany {
      return $this->belongsToMany(User::class)->withPivot('attempt')->withTimestamps();
    }
}
