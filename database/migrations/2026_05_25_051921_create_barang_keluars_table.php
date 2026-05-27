<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
<<<<<<< HEAD
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel barangs
=======
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {

            $table->id();

            // relasi ke barang
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');

            // jumlah barang keluar
            $table->integer('jumlah');

            // tanggal barang keluar
            $table->date('tanggal_keluar');

<<<<<<< HEAD
            // tujuan pengiriman (opsional)
            $table->string('tujuan')->nullable();

            // keterangan tambahan
            $table->text('keterangan')->nullable();

            // siapa yang input (hanya KTU)
=======
            // tujuan barang
            $table->string('tujuan')->nullable();

            // keterangan
            $table->text('keterangan')->nullable();

            // user yang input
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
<<<<<<< HEAD

            // index untuk filter laporan per barang & tanggal
            $table->index(['barang_id', 'tanggal_keluar']);
        });
    }

=======
        });
    }

    /**
     * Reverse the migrations.
     */
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
