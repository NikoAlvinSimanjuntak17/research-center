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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade'); // RELASI KE PROJECT
            $table->foreignId('researcher_id')->nullable()->constrained()->onDelete('cascade'); // RELASI KE RESEARCHER
            $table->string('title');
            $table->text('abstract')->nullable();
            $table->string('journal')->nullable();
            $table->string('doi')->nullable();
            $table->string('publication_date')->nullable();
            $table->string('source')->nullable(); // orcid, scopus, garuda
            $table->string('external_id')->nullable(); // ID dari sumber asli (misal: scopusId, orcidWorkId, dll)
            $table->json('authors')->nullable(); // bisa jadi array
            $table->text('raw_data')->nullable();
            $table->string('type')->nullable(); 
            $table->string('url')->nullable();
            $table->integer('citation_count')->default(0);    // jurnal, prosiding, dll.
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
