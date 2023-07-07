<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'post_id',
        'user_id',
        'is_active',
        'parent_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderByDesc('created_at');
    }

    public function parentComment(): belongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
