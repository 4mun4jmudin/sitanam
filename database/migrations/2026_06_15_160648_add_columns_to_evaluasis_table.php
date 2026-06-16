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
            $table->string('tingkat_hama_terberat')->nullable()->after('persentase_hasil');
            $table->string('kondisi_risiko_terburuk')->nullable()->after('tingkat_hama_terberat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluasis', function (Blueprint $table) {
            $table->dropColumn(['tingkat_hama_terberat', 'kondisi_risiko_terburuk']);
        });
    }
};
