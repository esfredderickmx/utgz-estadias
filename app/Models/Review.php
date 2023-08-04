<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
      'process_id',
      'number',
      'instructions',
      'status',
      'limit_date'
    ];

    public function process(): BelongsTo {
      return $this->belongsTo(Process::class);
    }

    public function files(): HasMany {
      return $this->hasMany(File::class);
    }

    public function comments(): HasMany {
      return $this->hasMany(Comment::class);
    }
}
