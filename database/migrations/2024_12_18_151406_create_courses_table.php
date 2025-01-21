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
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');
            $table->string('course_code');
            $table->string('course_title');
            $table->integer('unit');

            $table->unsignedBigInteger('dept_id')
                ->index();

            $table->unsignedBigInteger('level_id')
                ->index();

            $table->unsignedBigInteger('semester_id')
                ->index();

            $table->string('status');

            $table->unsignedBigInteger('user_id')
                ->index(); // course creator

            $table->timestamps();
        });

        Schema::table('courses', function ($table) {
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('courses', function ($table) {
            $table->foreign('dept_id')
                ->references('dept_id')
                ->on('depts')
                ->onDelete('cascade');
        });

        Schema::table('courses', function ($table) {
            $table->foreign('level_id')
                ->references('level_id')
                ->on('levels')
                ->onDelete('cascade');
        });

        Schema::table('courses', function ($table) {
            $table->foreign('semester_id')
                ->references('semester_id')
                ->on('semesters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
