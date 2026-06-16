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
        Schema::create('jenis_tanamans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tanaman', 100);
            $table->string('kategori_tanaman', 50); // Sayuran Daun, Umbi, dll
            $table->string('satuan_default', 20); // Ikat, Kg, Buah, dll
            $table->decimal('estimasi_bobot_per_satuan_kg', 8, 3)->nullable(); // Misal 0.2 untuk ikat
            $table->integer('umur_panen_hari')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_tanamans');
    }
};
