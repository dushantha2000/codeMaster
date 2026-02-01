<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SnippetFile extends Model
{
    protected $fillable = ['snippet_id', 'file_name', 'file_path', 'content', 'extension'];

    public function snippet()
    {
        return $this->belongsTo(Snippet::class);
    }
}
