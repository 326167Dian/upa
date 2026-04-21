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
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id('id_jurnal');
            $table->date('tanggal');
            $table->text('ket');
            $table->string('petugas', 30);
            $table->foreignId('idjenis')->constrained('jenis_jurnal', 'idjenis')->restrictOnDelete();
            $table->unsignedBigInteger('debit')->default(0);
            $table->unsignedBigInteger('kredit')->default(0);
            $table->string('carabayar', 8);
            $table->dateTime('current');
            $table->timestamp('created_by')->useCurrent();
            $table->foreignId('update_at')->nullable()->constrained('operators')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};