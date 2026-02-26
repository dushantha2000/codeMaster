<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'key_prefix',
        'key_hash',
        'last_used_at',
        'expires_at',
        'is_active'
    ];
    
    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];
    
    /**
     * Get the user that owns the API key.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Generate a new API key.
     */
    public static function generateKey()
    {
        return 'cm_' . bin2hex(random_bytes(24));
    }
    
    /**
     * Generate key prefix for display.
     */
    public static function generatePrefix()
    {
        return substr(bin2hex(random_bytes(4)), 0, 8);
    }
    
    /**
     * Hash the key for storage.
     */
    public static function hashKey($key)
    {
        return hash('sha256', $key);
    }
}
