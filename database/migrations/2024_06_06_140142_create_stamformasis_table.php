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
        Schema::create('stamformasis', function (Blueprint $table) {
            $table->id();
            // Suggested code may be subject to a license. Learn more: ~LicenseLog:2144109175.
            $table->date('tgl_stamformasi');
            $table->string('location');
            $table->string('status_pendinasan');
            $table->foreignId('lrv_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamformasis');
    }
};
