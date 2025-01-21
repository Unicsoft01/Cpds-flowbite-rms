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
        Schema::create('signatories', function (Blueprint $table) {
            $table->id('signatory_id');
            
            $table->unsignedBigInteger('user_id')->index(); // user who set those details
            
            $table->string('hod'); // HOD/Dir. of program
            $table->string('exam_officer'); // Esam officer/Cord. of the pro
            $table->timestamps();
        });
        
        Schema::table('signatories', function ($table) {
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
        Schema::dropIfExists('signatories');
    }
};