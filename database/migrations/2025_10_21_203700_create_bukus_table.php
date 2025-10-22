<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 50);
            $table->string('judul', 255);
            $table->string('cover', 255)->nullable();
            $table->text('sinopsis');
            $table->timestamps();
            
            // Add indexes for better search performance
            $table->index(['jenis']);
            $table->index(['judul']);
            $table->fullText(['judul', 'sinopsis']); // For better search
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};