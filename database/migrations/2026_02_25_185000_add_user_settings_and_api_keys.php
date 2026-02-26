<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('theme', ['light', 'dark', 'system'])->default('system')->after('is_verified');
            $table->string('editor_theme')->default('github-dark')->after('theme');
            $table->tinyInteger('tab_size')->default(2)->after('editor_theme');
            
            // Notification settings
            $table->boolean('email_notifications')->default(true)->after('tab_size');
            $table->boolean('comment_notifications')->default(false)->after('email_notifications');
            $table->boolean('marketing_emails')->default(false)->after('comment_notifications');
            
            // Privacy settings
            $table->boolean('public_profile')->default(true)->after('marketing_emails');
            $table->boolean('public_snippets')->default(true)->after('public_profile');
            $table->boolean('usage_analytics')->default(false)->after('public_snippets');
        });
        
        // Create API keys table
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('key_prefix', 10);
            $table->string('key_hash');
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'theme',
                'editor_theme',
                'tab_size',
                'email_notifications',
                'comment_notifications',
                'marketing_emails',
                'public_profile',
                'public_snippets',
                'usage_analytics'
            ]);
        });
        
        Schema::dropIfExists('api_keys');
    }
};
