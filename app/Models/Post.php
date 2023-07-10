<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
                'title',
                'slug',
                'thumbnail',
                'body',
                'active',
                'published_at',
                'user_id',
                'category_id',
                'meta_title',
                'meta_description',
                'title_en',
                'body_en',
                'meta_title_en',
                'meta_description_en',
                'related_post_id'
            ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function relatedTo(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'related_posts_id');
    }


    public function shortBody($words = 30): string
    {
        return Str::words(strip_tags(
            app()->getLocale() == 'en' ? $this->body_en : $this->body
        ),$words);
    }

    public function getFormattedDate(): string
    {
        return $this->published_at->format("F jS Y");
    }

    public function getThumbnail()
    {
        if (str_starts_with($this->thumbnail, 'http')){
            return $this->thumbnail;
        }
        return '/storage/' . $this->thumbnail;
    }

    public function humanReadTime(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                $words = Str::wordCount(
                    strip_tags(
                        app()->getLocale() == 'en' ? $attributes['body_en'] : $attributes['body']
                    )
                );
                $time = ceil($words / 200);

                return $time . " " . str(__('basic.minutes'))->plural($time) . ", $words " . str(__('basic.words'))->plural($words);
            }
        );
    }

}
