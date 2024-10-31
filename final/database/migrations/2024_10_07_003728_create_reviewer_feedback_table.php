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
        Schema::create('reviewer_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->unsignedBigInteger('reviewee_id');
            $table->integer('rating')->default(0);
            $table->string('feedback')->nullable();
            $table->timestamps();
    
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewee_id')->references('id')->on('users')->onDelete('cascade');
        });
    
        Schema::table('users', function (Blueprint $table) {
            $table->string('badge')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer_feedback');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('badge');
    });
    }
};
