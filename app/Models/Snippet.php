<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $fillable = ['title', 'description', 'language'];

    public function files()
    {
        return $this->hasMany(SnippetFile::class);
    }
}
