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
        Schema::create('jenis_jurnal', function (Blueprint $table) {
            $table->id('idjenis');
            $table->string('nm_jurnal', 100)->unique();
            $table->unsignedTinyInteger('tipe');
            $table->timestamp('created_by')->useCurrent();
            $table->foreignId('update_at')->nullable()->constrained('operators')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_jurnal');
    }
};