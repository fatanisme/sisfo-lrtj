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
        Schema::table('pendinasans', function (Blueprint $table) {
            $table->string('location')->nullable()->after('status_pendinasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendinasans', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
};
