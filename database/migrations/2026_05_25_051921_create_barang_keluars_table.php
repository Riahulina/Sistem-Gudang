<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel barangs
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');

            // jumlah barang keluar
            $table->integer('jumlah');

            // tanggal barang keluar
            $table->date('tanggal_keluar');

            // tujuan pengiriman (opsional)
            $table->string('tujuan')->nullable();

            // keterangan tambahan
            $table->text('keterangan')->nullable();

            // siapa yang input (hanya KTU)
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();

            // index untuk filter laporan per barang & tanggal
            $table->index(['barang_id', 'tanggal_keluar']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
