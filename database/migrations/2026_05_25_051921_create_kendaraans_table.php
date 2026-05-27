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
        Schema::create('kendaraans', function (Blueprint $table) {

            $table->id();

            // nama kendaraan
            $table->string('nama_kendaraan');

            // plat nomor unik
            $table->string('plat_nomor')->unique();

            // jenis kendaraan
            $table->string('jenis')->nullable();

            // kondisi kendaraan
            $table->enum('kondisi', [
                'baik',
                'servis',
                'rusak'
            ])->default('baik');

            // optional keterangan
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
        Schema::dropIfExists('kendaraans');
    }
};
