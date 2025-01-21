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
        Schema::create('levels', function (Blueprint $table) {
            $table->id('level_id');
            $table->string('level')->default('diploma 1')->unique();

            $table->unsignedBigInteger('programme_id')
                ->index();
                
            $table->timestamps();
        });

        Schema::table('levels', function ($table) {
            $table->foreign('programme_id')
                ->references('programme_id')
                ->on('programmes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};