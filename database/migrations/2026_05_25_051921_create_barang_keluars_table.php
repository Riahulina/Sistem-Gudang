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
        Schema::create('barang_keluars', function (Blueprint $table) {

            $table->id();

            // relasi ke barang
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');

            // jumlah barang keluar
            $table->integer('jumlah');

            // tanggal barang keluar
            $table->date('tanggal_keluar');

            // tujuan barang
            $table->string('tujuan')->nullable();

            // keterangan
            $table->text('keterangan')->nullable();

            // user yang input
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
