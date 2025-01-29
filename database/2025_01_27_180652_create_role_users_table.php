<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('role_users', function (Blueprint $table) {
    //         $table->id();

    //         $table->unsignedBigInteger('user_id')->index();
    //         $table->unsignedBigInteger('role_id')->index();

    //         // $table->foreignId('user_id')->constrained()->onDelete('cascade');
    //         // $table->foreignId('role_id')->constrained()->onDelete('cascade');
    //         $table->timestamps();
    //     });

    //     Schema::table('role_users', function ($table) {
    //         $table->foreign('user_id')
    //             ->references('user_id')
    //             ->on('users')
    //             ->onDelete('cascade');
    //     });
    //     Schema::table('role_users', function ($table) {
    //         $table->foreign('role_id')
    //             ->references('role_id')
    //             ->on('roles')
    //             ->onDelete('cascade');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('role_users');
    // }
};