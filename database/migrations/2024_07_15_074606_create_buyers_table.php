<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('buyer_type')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('business_type')->nullable();
            $table->string('company_legal_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('website')->nullable();
            $table->string('resale_business_type')->nullable();
            $table->string('hear_about_us')->nullable();
            $table->string('monthly_purchasing_ability')->nullable();
            $table->string('billing_address1')->nullable();
            $table->string('billing_address2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->boolean('same_as_billing')->default(false);
            $table->string('shipping_address1')->nullable();
            $table->string('shipping_address2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('account_first_name')->nullable();
            $table->string('account_last_name')->nullable();
            $table->string('account_phone')->nullable();
            $table->string('account_email')->nullable();
            $table->boolean('account_same_as_primary_contact')->default(false);
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_email')->nullable();
            $table->boolean('shipping_same_as_primary_contact')->default(false);
            $table->string('payment_method')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_title')->nullable();
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->string('business_license')->nullable();
            $table->string('address_proof')->nullable();
            $table->string('owner_eid')->nullable();
            $table->string('security_deposit_slip')->nullable();
            $table->string('tra_certificate')->nullable();
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
        Schema::dropIfExists('buyers');
    }
}
