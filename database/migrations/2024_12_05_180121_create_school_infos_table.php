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
        Schema::create('school_infos', function (Blueprint $table) {
            $table->id('school_id');
            $table->string('school_name')->unique()->default('Prince Abubakar Audu, University, Anyigba');
            $table->string('location')->default('P.M.B 100, Anyigba, Kogi State');
            $table->string('logo')->default('paau-logo.png');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_infos');
    }
};