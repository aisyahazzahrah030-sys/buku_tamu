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
            // Tambah kolom baru jika belum ada
            if (!Schema::hasColumn('guest_books', 'nama_opd')) {
                $table->string('nama_opd')->nullable()->after('keperluan');
            }
            if (!Schema::hasColumn('guest_books', 'nama_pejabat')) {
                $table->string('nama_pejabat')->nullable()->after('nama_opd');
            }
            
            // Hapus kolom lama jika ada
            $columnsToDrop = [];
            if (Schema::hasColumn('guest_books', 'sistem_terkait')) {
                $columnsToDrop[] = 'sistem_terkait';
            }
            if (Schema::hasColumn('guest_books', 'pegawai_dituju')) {
                $columnsToDrop[] = 'pegawai_dituju';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
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
