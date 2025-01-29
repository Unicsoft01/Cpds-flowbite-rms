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
        Schema::create('course_registerations', function (Blueprint $table) {
            $table->id('registration_id');

            $table->unsignedBigInteger('semester_id')->index();

            $table->unsignedBigInteger('student_id')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->unsignedBigInteger('session_id')->index();
            $table->unsignedBigInteger('level_id')->index();

            $table->string('registered_by')->default('Student');

            $table->boolean('is_carryover')->default(false);
            $table->boolean('is_spillover')->default(false);
            $table->boolean('result_status')->default(false);

            $table->unsignedBigInteger('user_id')->index(); // owner score computer

            $table->integer('score')->nullable();
            $table->integer('grade_point')->nullable(); // E.g., "4.00"

            $table->string('grade')->nullable(); // E.g., "A", "B"

            $table->timestamps();
        });

        Schema::table('course_registerations', function ($table) {
            $table->foreign('semester_id')
                ->references('semester_id')
                ->on('semesters')
                ->onDelete('cascade');
        });

        Schema::table('course_registerations', function ($table) {
            $table->foreign('student_id')
                ->references('student_id')
                ->on('students')
                ->onDelete('cascade');
        });

        Schema::table('course_registerations', function ($table) {
            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->onDelete('cascade');
        });

        Schema::table('course_registerations', function ($table) {
            $table->foreign('session_id')
                ->references('session_id')
                ->on('academic_sessions')
                ->onDelete('cascade');
        });

        Schema::table('course_registerations', function ($table) {
            $table->foreign('level_id')
                ->references('level_id')
                ->on('levels')
                ->onDelete('cascade');
        });


        Schema::table('course_registerations', function ($table) {
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_registerations');
    }
};