<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('connectivities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('model_id')->references('id')->on('model_names')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('connectivities');
    }
}
