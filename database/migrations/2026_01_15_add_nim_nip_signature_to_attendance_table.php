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
            $table->string('nim_nip')->nullable()->after('jurusan')->comment('NIM/NIP peserta');
            $table->longText('signature')->nullable()->after('jam_pulang')->comment('Digital signature (base64 encoded)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn(['nim_nip', 'signature']);
        });
    }
};
