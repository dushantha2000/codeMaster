<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'category_name',
        'category_description',
        'color_name',
        'isActive'
    ];

    public function snippets()
    {
        return $this->hasMany(Snippet::class, 'category_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
