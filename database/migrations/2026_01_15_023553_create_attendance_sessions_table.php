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
    Schema::create('attendance_sessions', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->dateTime('start_date');
        $table->dateTime('end_date')->nullable();
        $table->string('qr_code_token')->unique();
        
        // UBAH DUA BARIS INI:
        $table->unsignedBigInteger('created_by')->nullable(); // Tambahkan nullable()
        $table->timestamps();
        
        // HAPUS ATAU KOMENTAR BARIS FOREIGN KEY DI BAWAH INI:
        // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};
