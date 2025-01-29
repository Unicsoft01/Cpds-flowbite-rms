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
    //     Schema::create('role_permissions', function (Blueprint $table) {
    //         $table->id('role_permission_id');

    //         $table->unsignedBigInteger('role_id')->index();
    //         $table->unsignedBigInteger('permission_id')->index();

    //         // $table->foreignId('role_id')->constrained()->onDelete('cascade');
    //         // $table->foreignId('permission_id')->constrained()->onDelete('cascade');
    //         $table->timestamps();
    //     });

    //     Schema::table('role_permissions', function ($table) {
    //         $table->foreign('role_id')
    //             ->references('role_id')
    //             ->on('roles')
    //             ->onDelete('cascade');
    //     });
    //     Schema::table('role_permissions', function ($table) {
    //         $table->foreign('permission_id')
    //             ->references('permission_id')
    //             ->on('permissions')
    //             ->onDelete('cascade');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('role_permissions');
    // }
};