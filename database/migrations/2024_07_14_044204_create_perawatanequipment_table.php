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
        Schema::create('perawatan_equipment', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_perawatan')->nullable();
            $table->foreignId('equipment_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('jenis_perawatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perawatan_equipment');
    }
};
