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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');

            $table->string('surname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('firstname')->nullable();

            $table->string('regno')->nullable();
            $table->string('phone')->nullable();

            // $table->year('set');
            $table->unsignedBigInteger('set')->default('1')->index();

            $table->unsignedBigInteger('programme_id')->default('1')->index();
            $table->unsignedBigInteger('faculty_id')->index();
            $table->unsignedBigInteger('dept_id')->index();

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });


        Schema::table('students', function ($table) {
            $table->foreign('programme_id')
                ->references('programme_id')
                ->on('programmes')
                ->onDelete('cascade');
        });

        Schema::table('students', function ($table) {
            $table->foreign('dept_id')
                ->references('dept_id')
                ->on('depts')
                ->onDelete('cascade');
        });

        Schema::table('students', function ($table) {
            $table->foreign('faculty_id')
                ->references('faculty_id')
                ->on('faculties')
                ->onDelete('cascade');
        });
        Schema::table('students', function ($table) {
            $table->foreign('set')
                ->references('session_id')
                ->on('academic_sessions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};