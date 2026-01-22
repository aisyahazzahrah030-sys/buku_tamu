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
        // Update data existing
        DB::table('guest_books')
            ->where('kategori_tamu', 'masyarakat-umum')
            ->update(['kategori_tamu' => 'umum']);

        Schema::table('guest_books', function (Blueprint $table) {
            $table->enum('kategori_tamu', ['opd-padang', 'pemerintah-lain', 'umum'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_books', function (Blueprint $table) {
            $table->enum('kategori_tamu', ['opd-padang', 'pemerintah-lain', 'masyarakat-umum'])->change();
        });

        DB::table('guest_books')
            ->where('kategori_tamu', 'umum')
            ->update(['kategori_tamu' => 'masyarakat-umum']);
    }
};
