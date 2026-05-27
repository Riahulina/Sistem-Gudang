<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
<<<<<<< HEAD
=======
    /**
     * Run the migrations.
     */
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD

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

=======
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
            $table->timestamps();
        });
    }

<<<<<<< HEAD
=======
    /**
     * Reverse the migrations.
     */
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
