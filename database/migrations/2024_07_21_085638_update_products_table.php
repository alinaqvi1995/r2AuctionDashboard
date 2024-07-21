<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('reference')->nullable();
            $table->string('listing_type')->nullable();
            $table->string('material')->nullable();
            $table->string('generation')->nullable();
            $table->string('connectivity')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('auction_name')->nullable();
            $table->string('lot_address')->nullable();
            $table->string('lot_city')->nullable();
            $table->string('lot_state')->nullable();
            $table->string('lot_zip')->nullable();
            $table->string('lot_country')->nullable();
            $table->boolean('international_buyers')->default(0);
            $table->text('shipping_requirements')->nullable();
            $table->boolean('certificate_data_erasure')->default(0);
            $table->boolean('certificate_hardware_destruction')->default(0);
            $table->boolean('lot_sold_as_is')->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('bidding_close_time')->nullable();
            $table->integer('processing_time')->default(0);
            $table->string('minimum_bid_price')->nullable();
            $table->boolean('buy_now')->default(0);
            $table->string('buy_now_price')->nullable();
            $table->string('reserve_price')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'reference',
                'listing_type',
                'material',
                'generation',
                'connectivity',
                'quantity',
                'auction_name',
                'lot_address',
                'lot_city',
                'lot_state',
                'lot_zip',
                'lot_country',
                'international_buyers',
                'shipping_requirements',
                'certificate_data_erasure',
                'certificate_hardware_destruction',
                'lot_sold_as_is',
                'notes',
                'bidding_close_time',
                'processing_time',
                'minimum_bid_price',
                'buy_now',
                'buy_now_price',
                'reserve_price',
            ]);
        });
    }
}
