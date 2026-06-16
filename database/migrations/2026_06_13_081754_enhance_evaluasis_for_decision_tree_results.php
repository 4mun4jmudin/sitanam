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
        Schema::table('evaluasis', function (Blueprint $table) {
            $table->decimal('skor', 5, 2)->nullable()->after('hasil_klasifikasi');
            $table->decimal('persentase_hidup', 5, 2)->nullable()->after('skor');
            $table->decimal('persentase_hasil', 5, 2)->nullable()->after('persentase_hidup');
            $table->json('faktor_utama')->nullable()->after('rincian_aturan');
            $table->json('rekomendasi')->nullable()->after('faktor_utama');
            $table->string('metode_algoritma')->default('rule_based_decision_tree')->after('rekomendasi');
            $table->string('versi_algoritma')->default('v1.0')->after('metode_algoritma');
            $table->timestamp('evaluated_at')->nullable()->after('versi_algoritma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluasis', function (Blueprint $table) {
            $table->dropColumn([
                'skor', 
                'persentase_hidup', 
                'persentase_hasil', 
                'faktor_utama', 
                'rekomendasi', 
                'metode_algoritma', 
                'versi_algoritma', 
                'evaluated_at'
            ]);
        });
    }
};
