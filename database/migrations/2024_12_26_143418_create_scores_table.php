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
        Schema::create('scores', function (Blueprint $table) {
            $table->id('score_id');

            $table->unsignedBigInteger('registration_id')->index();
            $table->unsignedBigInteger('user_id')->index(); // owner score computer

            $table->integer('score')->nullable();
            $table->integer('grade_point')->nullable(); // E.g., "4.00"

            $table->string('grade')->nullable(); // E.g., "A", "B"

            $table->timestamps();
        });

        Schema::table('scores', function ($table) {
            $table->foreign('registration_id')
                ->references('registration_id')
                ->on('course_registerations')
                ->onDelete('cascade');
        });

        Schema::table('scores', function ($table) {
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
        Schema::dropIfExists('scores');
    }
};