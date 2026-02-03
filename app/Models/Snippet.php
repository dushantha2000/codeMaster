<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $fillable = ['title', 'description', 'language', 'user_id'];

    public function files()
    {
        return $this->hasMany(SnippetFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
