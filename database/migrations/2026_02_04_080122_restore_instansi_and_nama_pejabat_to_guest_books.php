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
        Schema::table('guest_books', function (Blueprint $table) {
            if (!Schema::hasColumn('guest_books', 'instansi')) {
                $table->string('instansi')->nullable()->after('nomor_hp');
            }
            if (!Schema::hasColumn('guest_books', 'nama_pejabat')) {
                $table->string('nama_pejabat')->nullable()->after('nama_opd');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_books', function (Blueprint $table) {
            $table->dropColumn(['instansi', 'nama_pejabat']);
        });
    }
};
