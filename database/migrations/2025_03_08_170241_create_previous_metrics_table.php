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
        Schema::create('previous_metrics', function (Blueprint $table) {
            $table->id('metric_id');
            $table->integer('tcr')->nullable();
            $table->integer('tce')->nullable();
            $table->integer('tgp')->nullable();
            $table->integer('gpa')->nullable();

            $table->unsignedBigInteger('semester_id')->nullable();

            $table->unsignedBigInteger('student_id')->nullable();
            // $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('dept_id')->nullable();

            $table->timestamps();
        });

        Schema::table('previous_metrics', function ($table) {
            $table->foreign('semester_id')
                ->references('semester_id')
                ->on('semesters')
                ->onDelete('cascade');
        });

        Schema::table('previous_metrics', function ($table) {
            $table->foreign('student_id')
                ->references('student_id')
                ->on('students')
                ->onDelete('cascade');
        });

        Schema::table('previous_metrics', function ($table) {
            $table->foreign('session_id')
                ->references('session_id')
                ->on('academic_sessions')
                ->onDelete('cascade');
        });

        Schema::table('previous_metrics', function ($table) {
            $table->foreign('level_id')
                ->references('level_id')
                ->on('levels')
                ->onDelete('cascade');
        });

        Schema::table('previous_metrics', function ($table) {
            $table->foreign('dept_id')
                ->references('dept_id')
                ->on('depts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previous_metrics');
    }
};
