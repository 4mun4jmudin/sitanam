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
            $table->decimal('target_panen_kg', 8, 2)->nullable()->after('jml_bibit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penanamen', function (Blueprint $table) {
            $table->dropColumn('target_panen_kg');
        });
    }
};
