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
        Schema::table('attendance', function (Blueprint $table) {
            // Add new columns for time tracking
            $table->string('jurusan')->nullable()->after('institution');
            $table->time('jam_datang')->nullable()->after('jurusan');
            $table->time('jam_pulang')->nullable()->after('jam_datang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn(['jurusan', 'jam_datang', 'jam_pulang']);
        });
    }
};
