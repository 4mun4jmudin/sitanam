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
        Schema::table('panens', function (Blueprint $table) {
            $table->decimal('jumlah_hasil_panen', 10, 2)->nullable();
            $table->string('satuan_hasil_panen', 20)->nullable();
            $table->decimal('bobot_panen_kg', 10, 2)->nullable();
            
            // Make legacy nullable
            $table->decimal('bobot_panen', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panens', function (Blueprint $table) {
            $table->dropColumn(['jumlah_hasil_panen', 'satuan_hasil_panen', 'bobot_panen_kg']);
            
            // Revert legacy changes (best effort)
            $table->decimal('bobot_panen', 8, 2)->nullable(false)->change();
        });
    }
};
