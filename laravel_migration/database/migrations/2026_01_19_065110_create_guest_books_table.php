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
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nomor_hp');
            $table->string('email')->nullable();
            $table->string('instansi');
            $table->enum('kategori_tamu', ['opd-padang', 'pemerintah-lain', 'mahasiswa-akademisi', 'perusahaan-vendor', 'masyarakat-umum']);
            $table->enum('jenis_layanan', ['pengembangan-aplikasi', 'integrasi-sistem', 'website-opd', 'data-statistik', 'keamanan-informasi', 'konsultasi-layanan-digital']);
            $table->text('keperluan');
            $table->string('sistem_terkait')->nullable();
            $table->string('pegawai_dituju')->nullable();
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan');
            $table->string('foto_tamu')->nullable();
            $table->boolean('persetujuan')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_books');
    }
};
