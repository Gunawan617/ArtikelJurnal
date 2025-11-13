<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reference extends Model
{
    protected $fillable = [
        'article_id', 'author', 'title', 'year', 'journal', 'doi', 'url', 'order'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
