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
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id('id_kehadiran');
            $table->foreignId('id')->constrained('operators')->cascadeOnDelete();
            $table->foreignId('id_kegiatan')->constrained('kegiatan', 'id_kegiatan')->cascadeOnDelete();
            $table->dateTime('waktu');
            $table->integer('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};