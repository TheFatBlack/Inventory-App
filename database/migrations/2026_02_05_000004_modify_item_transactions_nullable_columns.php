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
        Schema::table('item_transactions', function (Blueprint $table) {
            // Make petugas_id and pengguna_id nullable
            $table->dropConstrainedForeignId('petugas_id');
            $table->dropConstrainedForeignId('pengguna_id');
            
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->cascadeOnDelete();
            $table->foreignId('pengguna_id')->nullable()->constrained('penggunas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('petugas_id');
            $table->dropConstrainedForeignId('pengguna_id');
            
            $table->foreignId('petugas_id')->constrained('petugas')->cascadeOnDelete();
            $table->foreignId('pengguna_id')->constrained('penggunas')->cascadeOnDelete();
        });
    }
};
