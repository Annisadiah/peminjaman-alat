<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('users')->restrictOnDelete();
            $table->dateTime('tgl_kembali');
            $table->string('kondisi_kembali', 100);
            $table->unsignedInteger('denda')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
