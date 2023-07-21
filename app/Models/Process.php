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
      'company_id',
      'grade',
      'attempt',
      'type',
      'status'
    ];

    public function period(): BelongsTo {
      return $this->belongsTo(Period::class);
    }

    public function company(): BelongsTo {
      return $this->belongsTo(Company::class);
    }

    public function reviews(): HasMany {
      return $this->hasMany(Review::class);
    }

    public function users(): BelongsToMany {
      return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function student() {
      return $this->belongsToMany(User::class)->where('role', 'student')->limit(1);
    }

    public function adviser() {
      return $this->belongsToMany(User::class)->where('role', 'adviser')->limit(1);
    }
}
