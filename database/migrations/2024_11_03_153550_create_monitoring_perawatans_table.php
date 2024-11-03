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
        Schema::create('monitoring_perawatans', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_perawatan');
            $table->string('jenis_perawatan')->nullable();
            $table->string('durasi')->nullable();
            $table->string('persentase_penyelesaian')->nullable();
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->foreignId('lrv_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_perawatans');
    }
};
