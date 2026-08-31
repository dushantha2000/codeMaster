<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareLink extends Model
{
    protected $fillable = [
        'snippet_id',
        'token_hash',
        'password',
        'expires_at',
        'views_count',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public function snippet()
    {
        return $this->belongsTo(Snippet::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
