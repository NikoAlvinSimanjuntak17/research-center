<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('partnerships', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama mitra
        $table->text('description'); // Penjelasan lengkap kerja sama
        $table->string('image')->nullable(); // Logo mitra (opsional)
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnerships');
    }
};
