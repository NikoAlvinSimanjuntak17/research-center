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
        Schema::create('researchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('academic_position')->nullable();
            $table->string('expertise')->nullable();
            $table->string('orcid_id')->nullable();
            $table->string('scopus_id')->nullable();
            $table->string('garuda_id')->nullable();
            $table->string('googlescholar_id')->nullable();
            $table->text('bio')->nullable();
            $table->string('url')->nullable();
            $table->integer('citation_count')->default(0);
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researchers');
    }
};
