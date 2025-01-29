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
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('permission_id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Role-Permission pivot table
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id('role_permission_id');
            $table->unsignedBigInteger('role_id')->index();
            $table->unsignedBigInteger('permission_id')->index();
            $table->timestamps();
        });

        // User-Role pivot table
        Schema::create('role_user', function (Blueprint $table) {
            $table->id('role_user_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->timestamps();
        });

        // User-student pivot table
        Schema::create('role_student', function (Blueprint $table) {
            $table->id('role_student_id');
            $table->unsignedBigInteger('student_id')->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->timestamps();
        });

        // relationship
        Schema::table('role_permission', function ($table) {
            $table->foreign('role_id')
                ->references('role_id')
                ->on('roles')
                ->onDelete('cascade');
        });
        Schema::table('role_permission', function ($table) {
            $table->foreign('permission_id')
                ->references('permission_id')
                ->on('permissions')
                ->onDelete('cascade');
        });
        Schema::table('role_user', function ($table) {
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
        Schema::table('role_user', function ($table) {
            $table->foreign('role_id')
                ->references('role_id')
                ->on('roles')
                ->onDelete('cascade');
        });
        // student own
        Schema::table('role_student', function ($table) {
            $table->foreign('student_id')
                ->references('student_id')
                ->on('students')
                ->onDelete('cascade');
        });
        Schema::table('role_student', function ($table) {
            $table->foreign('role_id')
                ->references('role_id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('roles_and_permissions_tables');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('role_student');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};