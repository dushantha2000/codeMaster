<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('snippets', function (Blueprint $table) {
        $table->index('user_id');
        $table->index('language');
        $table->index(['title', 'language']); // Combined index for faster filtering
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('snippets', function (Blueprint $table) {
        $table->dropIndex(['user_id']);
        $table->dropIndex(['language']);
        $table->dropIndex(['title', 'language']);
    });
}
};
