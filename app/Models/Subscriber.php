<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'user_id', 'send_mail'];
    protected $table = 'subscribers';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
