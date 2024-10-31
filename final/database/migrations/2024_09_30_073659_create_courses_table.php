<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('course_code')->unique(); 
            $table->string('name'); 
            $table->unsignedBigInteger('teacher_id')->nullable(); // Teacher ID (foreign key)

            // Foreign key constraint
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
        });

        Schema::dropIfExists('courses');
    }
}
