<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'related_keywords',
        'replies_count',
        'last_reply_at',
        'is_closed',
    ];

    protected $casts = [
        'last_reply_at' => 'datetime',
        'is_closed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class)->whereNull('parent_id')->latest();
    }

    public function allReplies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class)->latest();
    }

    public function reports()
    {
        return $this->morphMany(UserReport::class, 'reportable');
    }
}
