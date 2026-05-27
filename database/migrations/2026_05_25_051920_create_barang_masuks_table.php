<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
<<<<<<< HEAD
    public function up(): void
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel barangs
=======
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_masuks', function (Blueprint $table) {

            $table->id();

            // relasi ke tabel barang
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');

            // jumlah barang masuk
            $table->integer('jumlah');

            // tanggal barang masuk
            $table->date('tanggal_masuk');

<<<<<<< HEAD
            // asal supplier (opsional)
=======
            // optional supplier
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
            $table->string('supplier')->nullable();

            // keterangan tambahan
            $table->text('keterangan')->nullable();

<<<<<<< HEAD
            // siapa yang input (hanya KTU)
=======
            // siapa yang input
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
<<<<<<< HEAD

            // index untuk filter laporan per barang & tanggal
            $table->index(['barang_id', 'tanggal_masuk']);
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
        Schema::dropIfExists('barang_masuks');
    }
};
