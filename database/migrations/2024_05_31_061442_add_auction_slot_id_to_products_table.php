<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuctionSlotIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_slot_id')->nullable()->after('manufacturer_id');
            $table->string('lot_no')->after('auction_slot_id');
            $table->foreign('auction_slot_id')->references('id')->on('auction_slots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['auction_slot_id']);
            $table->dropColumn('auction_slot_id');
        });
    }
}
