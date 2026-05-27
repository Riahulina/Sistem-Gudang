<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();

            // kode unik barang (misal: BRG-001)
            $table->string('kode_barang')->unique();

            // nama barang
            $table->string('nama_barang');

            // relasi ke tabel kategoris
            $table->foreignId('kategori_id')
                ->nullable()
                ->constrained('kategoris')
                ->onDelete('set null');

            // stok saat ini (otomatis update saat transaksi)
            $table->integer('stok')->default(0);

            // satuan barang (pcs, kg, liter, dll)
            $table->string('satuan', 50);

            // batas minimum stok untuk notifikasi
            // jika stok <= minimum_stok maka muncul notifikasi
            $table->integer('minimum_stok')->default(20);

            // keterangan tambahan opsional
            $table->text('keterangan')->nullable();

            // siapa yang input barang
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
