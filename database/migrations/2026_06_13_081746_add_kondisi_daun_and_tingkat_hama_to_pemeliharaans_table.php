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
            $table->enum('kondisi_daun', ['Sehat', 'Menguning', 'Layu'])->nullable()->after('tinggi_tanaman');
            $table->enum('tingkat_hama', ['Tidak Ada', 'Ringan', 'Sedang', 'Berat'])->nullable()->after('info_hama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropColumn(['kondisi_daun', 'tingkat_hama']);
        });
    }
};
