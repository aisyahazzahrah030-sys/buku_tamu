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
            // Tambah kolom baru
            $table->string('nama_opd')->nullable()->after('keperluan');
            $table->string('nama_pejabat')->nullable()->after('nama_opd');
            
            // Hapus kolom lama
            $table->dropColumn(['sistem_terkait', 'pegawai_dituju']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_books', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->string('sistem_terkait')->nullable();
            $table->string('pegawai_dituju')->nullable();
            
            // Hapus kolom baru
            $table->dropColumn(['nama_opd', 'nama_pejabat']);
        });
    }
};
