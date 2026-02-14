<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    protected $fillable = ["user_id", "partner_id", "is_read", "is_edit"];

    public function owner()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function partner()
    {
        return $this->belongsTo(User::class, "partner_id");
    }
}
