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
        Schema::create('depts', function (Blueprint $table) {
            $table->id('dept_id');
            $table->string('department');

            $table->unsignedBigInteger('faculty_id')
                ->index();

            $table->unsignedBigInteger('user_id')
                ->index(); //creator

            $table->timestamps();
        });

        Schema::table('depts', function ($table) {
            $table->foreign('faculty_id')
                ->references('faculty_id')
                ->on('faculties')
                ->onDelete('cascade');
        });

        Schema::table('depts', function ($table) {
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
        Schema::dropIfExists('depts');
    }
};