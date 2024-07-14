<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->constrained()->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('description');
            $table->string('guard_name')->default('web');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->foreignId('user_id')->unsigned()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['permission_id', 'role_id']);
            $table->timestamps();
            $table->softDeletes();
        });

        // Example: Create a pivot table for assigning roles to users
        Schema::create('user_roles', function (Blueprint $table) {
            $table->foreignId('user_id')->unsigned()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['user_id', 'role_id']);
            $table->timestamps();
            $table->softDeletes();
        });

        // Example: Create a pivot table for assigning permissions to roles
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->foreignId('user_id')->unsigned()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->primary(['role_id', 'permission_id']);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
