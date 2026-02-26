<?php

namespace App\Models;

// 1. මේ පේළිය අලුතින් ඇතුළත් කරන්න (Sanctum සඳහා)
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ApiKey;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    // HasApiTokens
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ["user_id", "name", "email", "password", "theme", "editor_theme", "tab_size", "email_notifications", "comment_notifications", "marketing_emails", "public_profile", "public_snippets", "usage_analytics"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "email_notifications" => "boolean",
            "comment_notifications" => "boolean",
            "marketing_emails" => "boolean",
            "public_profile" => "boolean",
            "public_snippets" => "boolean",
            "usage_analytics" => "boolean",
        ];
    }
    
    /**
     * Get the user's API keys.
     */
    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }
}
