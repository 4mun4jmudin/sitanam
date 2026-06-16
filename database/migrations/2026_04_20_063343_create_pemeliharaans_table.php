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
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penanaman_id')->constrained('penanamen')->cascadeOnDelete();
            $table->integer('minggu_ke');
            $table->date('tanggal_catat');
            $table->float('tinggi_tanaman');
            $table->integer('jml_hidup');
            $table->integer('jml_mati');
            $table->string('info_hama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');
    }
};
