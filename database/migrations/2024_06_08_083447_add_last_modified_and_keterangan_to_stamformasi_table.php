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
        Schema::table('stamformasis', function (Blueprint $table) {
            $table->timestamp('last_modified')->nullable();
            $table->string('keterangan')->nullable()->after('last_modified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stamformasis', function (Blueprint $table) {

            $table->dropColumn('last_modified');
            $table->dropColumn('keterangan')->nullable();
        });
    }
};
