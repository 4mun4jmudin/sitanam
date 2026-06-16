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
        Schema::table('penanamen', function (Blueprint $table) {
            $table->foreignId('jenis_tanaman_id')->nullable()->constrained('jenis_tanamans')->nullOnDelete();
            $table->string('kategori_tanaman', 50)->nullable();
            $table->decimal('target_panen_jumlah', 10, 2)->nullable();
            $table->string('target_panen_satuan', 20)->nullable();
            $table->decimal('estimasi_bobot_per_satuan_kg', 8, 3)->nullable();

            // Make legacy nullable
            $table->string('jenis_tanaman')->nullable()->change();
            $table->decimal('target_panen_kg', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penanamen', function (Blueprint $table) {
            $table->dropForeign(['jenis_tanaman_id']);
            $table->dropColumn([
                'jenis_tanaman_id',
                'kategori_tanaman',
                'target_panen_jumlah',
                'target_panen_satuan',
                'estimasi_bobot_per_satuan_kg'
            ]);
            
            // Revert legacy changes (best effort, depending on original constraints)
            $table->string('jenis_tanaman')->nullable(false)->change();
            $table->decimal('target_panen_kg', 10, 2)->nullable(false)->change();
        });
    }
};
