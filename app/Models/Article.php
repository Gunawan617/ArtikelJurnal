<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'abstract', 'keywords', 'author', 'content',
        'category', 'category_color',
        'author_title', 'author_bio', 'author_photo', 'author_institution',
        'editor_name', 'editor_title', 'reviewer_name', 'reviewer_title',
        'pdf_path', 'image_path', 'published_at', 'is_published', 'user_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function references(): HasMany
    {
        return $this->hasMany(Reference::class)->orderBy('order');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->where('approved', true);
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
