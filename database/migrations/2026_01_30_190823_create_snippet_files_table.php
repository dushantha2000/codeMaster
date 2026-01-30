<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('snippet_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('snippet_id')->constrained()->onDelete('cascade'); 
            $table->string('file_name'); // උදා: UserController.php
            $table->string('file_path')->nullable(); // උදා: app/Http/Controllers
            $table->longText('content'); // කෝඩ් එක
            $table->string('extension'); // php, html, js ආදිය
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snippet_files');
    }
};