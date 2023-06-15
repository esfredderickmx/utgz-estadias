<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'review_id',
      'name',
      'type'
    ];

    public function user(): BelongsTo {
      return $this->belongsTo(User::class);
    }

    public function review(): BelongsTo {
      return $this->belongsTo(Review::class);
    }
}
