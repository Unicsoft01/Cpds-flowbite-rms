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
        Schema::create('grades', function (Blueprint $table) {
            $table->id('grade_id');
            $table->string('a')->default('A');
            $table->integer('a_lower_bound')->default(70);
            $table->integer('a_upper_bound')->default(100);
            $table->integer('a_grade_point')->default(10);
            $table->string('b')->default('B');
            $table->integer('b_lower_bound')->default(60);
            $table->integer('b_upper_bound')->default(69);
            $table->integer('b_grade_point')->default(8);
            $table->string('c')->default('C');
            $table->integer('c_lower_bound')->default(50);
            $table->integer('c_upper_bound')->default(59);
            $table->integer('c_grade_point')->default(6);
            $table->string('d')->default('D');
            $table->integer('d_lower_bound')->default(45);
            $table->integer('d_upper_bound')->default(49);
            $table->integer('d_grade_point')->default(4);
            $table->string('e')->default('E');
            $table->integer('e_lower_bound')->default(40);
            $table->integer('e_upper_bound')->default(44);
            $table->integer('e_grade_point')->default(2);
            $table->string('f')->default('F');
            $table->integer('f_lower_bound')->default(0);
            $table->integer('f_upper_bound')->default(39);
            $table->integer('f_grade_point')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
