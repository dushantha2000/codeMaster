<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary increment ID
            $table->string('category_id')->unique(); // Foreign key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category_name');
            $table->string('color_name');
            $table->text('category_description')->nullable();
            $table->tinyInteger('isActive')->default(1);
            $table->timestamps();

            $table->unique(['user_id', 'category_name'], 'user_category_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
