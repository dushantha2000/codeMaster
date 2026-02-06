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
            $table->string('file_name'); 
            $table->string('file_path')->nullable(); 
            $table->longText('content'); 
            $table->string('extension'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snippet_files');
    }
};