<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('user_username'); // Use username instead of user_id
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->integer('progress')->default(0);
            $table->integer('target')->default(1);
            $table->date('tanggal_record');
            $table->timestamps();
            
            // Add foreign key constraint
            $table->foreign('user_username')->references('username')->on('users')->onDelete('cascade');
            
            // Add indexes
            $table->index(['user_username', 'buku_id']);
            $table->index(['tanggal_record']);
            $table->index(['progress', 'target']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};