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
        Schema::table('pemeliharaans', function (Blueprint $table) {
            // Make existing fields nullable
            $table->float('tinggi_tanaman')->nullable()->change();
            $table->string('kondisi_daun')->nullable()->change();

            // Add new dynamic fields
            $table->json('kegiatan_json')->nullable();
            $table->string('kondisi_visual')->nullable();
            $table->json('indikator_tambahan_json')->nullable();
            $table->string('status_pertumbuhan')->nullable();
            $table->text('catatan_pemeliharaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropColumn([
                'kegiatan_json',
                'kondisi_visual',
                'indikator_tambahan_json',
                'status_pertumbuhan',
                'catatan_pemeliharaan'
            ]);

            $table->float('tinggi_tanaman')->nullable(false)->change();
            $table->string('kondisi_daun')->nullable(false)->change();
        });
    }
};
