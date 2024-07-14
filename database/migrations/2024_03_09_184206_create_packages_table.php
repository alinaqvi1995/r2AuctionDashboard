<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->constrained()->onDelete('cascade');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->longText('description')->nullable();
            $table->enum('ecommerce', ['true', 'false'])->default('false');
            $table->enum('events', ['true', 'false'])->default('false');
            $table->enum('music', ['true', 'false'])->default('false');
            $table->enum('appointment', ['true', 'false'])->default('false');
            $table->enum('ad_space', ['true', 'false'])->default('false');
            $table->enum('blogging', ['true', 'false'])->default('false');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
