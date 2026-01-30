<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('snippets', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // ප්‍රොජෙක්ට් එකේ නම
            $table->text('description')->nullable(); // විස්තරයක්
            $table->string('language')->default('php'); // පයිතන්, ලැරවල් ආදිය
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snippets');
    }
};