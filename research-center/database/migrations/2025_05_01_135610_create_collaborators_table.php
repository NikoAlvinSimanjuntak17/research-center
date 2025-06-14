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
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('researcher_id')->nullable()->constrained()->onDelete('set null'); // Tambahan
            
            $table->string('position');
            $table->string('institution')->nullable();
            $table->string('department')->nullable();
            $table->string('expertise')->nullable();
            $table->text('cv')->nullable();
            $table->text('reason')->nullable();
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_leader')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['project_id', 'user_id']);
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
