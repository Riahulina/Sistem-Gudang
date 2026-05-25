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
        Schema::create('barang_masuks', function (Blueprint $table) {

            $table->id();

            // relasi ke tabel barang
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');

            // jumlah barang masuk
            $table->integer('jumlah');

            // tanggal barang masuk
            $table->date('tanggal_masuk');

            // optional supplier
            $table->string('supplier')->nullable();

            // keterangan tambahan
            $table->text('keterangan')->nullable();

            // siapa yang input
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
        Schema::dropIfExists('barang_masuks');
    }
};
