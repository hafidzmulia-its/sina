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
        Schema::table('histories', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['user_username']);
            
            // Add the foreign key constraint with CASCADE on both DELETE and UPDATE
            $table->foreign('user_username')
                  ->references('username')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('histories', function (Blueprint $table) {
            // Drop the updated foreign key constraint
            $table->dropForeign(['user_username']);
            
            // Restore the original foreign key constraint (without onUpdate cascade)
            $table->foreign('user_username')
                  ->references('username')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};
