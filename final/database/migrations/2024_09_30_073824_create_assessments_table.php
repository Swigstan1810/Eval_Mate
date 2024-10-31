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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); 
            $table->string('title', 20); 
            $table->text('instructions'); 
            $table->unsignedInteger('number_of_reviews'); 
            $table->unsignedInteger('maximum_score')->between(1, 100); 
            $table->timestamp('due_date'); 
            $table->enum('type', ['student-select', 'teacher-assign']); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments'); 
    }
};
