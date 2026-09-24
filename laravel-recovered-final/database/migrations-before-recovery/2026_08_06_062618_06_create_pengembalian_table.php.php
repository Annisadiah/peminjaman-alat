<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::creae('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->contraied('peminjaman')->cascadeOnDelete();
            $table->date('tgl_kembali');
            $table->string('kondisi_kembali');
            $table->integer('denda')->default(0);
            $table->foreignId('petugas_id')->constrained('user')->cascadeonDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
