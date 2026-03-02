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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
