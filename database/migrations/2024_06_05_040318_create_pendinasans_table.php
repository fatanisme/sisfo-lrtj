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
        Schema::create('pendinasans', function (Blueprint $table) {
            $table->id();
            $table->datetime('tgl_pendinasan');
            $table->foreignId('lrv_id')->constrained()->cascadeOnDelete();
            $table->string('status_pendinasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendinasans');
    }
};
