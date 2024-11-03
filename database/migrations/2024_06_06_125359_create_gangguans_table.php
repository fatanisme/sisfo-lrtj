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
        Schema::create('gangguans', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_gangguan');
            $table->foreignId('lrv_id')->constrained()->cascadeOnDelete();
            $table->string('kabin');
            $table->string('informasi_gangguan')->nullable();
            $table->string('andil_keterlambatan')->nullable();
            $table->string('sistem_utama')->nullable();
            $table->string('perangkat_spesifik')->nullable();
            $table->string('deskripsi_fault')->nullable();
            $table->string('status_maximo')->nullable();
            $table->string('service_request')->nullable();
            $table->string('status_action')->nullable();
            $table->string('tindak_lanjut')->nullable();
            $table->dateTime('action_date')->nullable();
            $table->dateTime('deadline_monitoring')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->string('penggunaan_sparepart')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gangguans');
    }
};
