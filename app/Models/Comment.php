<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'process_id',
      'review_id',
      'message',
      'date',
      'time'
    ];

    public function user(): BelongsTo {
      return $this->belongsTo(User::class);
    }

    public function process(): BelongsTo {
      return $this->belongsTo(Process::class);
    }

    public function review(): BelongsTo {
      return $this->belongsTo(Review::class);
    }
}
