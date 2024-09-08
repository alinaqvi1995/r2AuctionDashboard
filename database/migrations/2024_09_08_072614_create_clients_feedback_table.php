<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('description');
            $table->integer('rating')->default(0);
            $table->tinyInteger('status')->default(0); // or use tinyInteger if you want multiple statuses
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients_feedback');
    }
}
