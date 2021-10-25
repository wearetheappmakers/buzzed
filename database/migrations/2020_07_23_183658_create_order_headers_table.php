<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('currency')->nullable();
            $table->string('shipping_fullname');
            $table->string('shipping_country_name');
            $table->string('shipping_country_phone_code')->nullable();
            $table->string('shipping_country_code')->nullable();
            $table->string('shipping_city_name');
            $table->string('shipping_city_code')->nullable();
            $table->string('shipping_state_name');
            $table->string('shipping_state_code')->nullable();
            $table->string('shipping_pincode')->nullable();
            $table->string('shipping_mobile')->nullable();
            $table->string('billing_fullname');
            $table->string('billing_country_name');
            $table->string('billing_country_phone_code')->nullable();
            $table->string('billing_country_code')->nullable();
            $table->string('billing_city_name');
            $table->string('billing_city_code')->nullable();
            $table->string('billing_state_name');
            $table->string('billing_state_code')->nullable();
            $table->string('billing_pincode')->nullable();
            $table->string('billing_mobile')->nullable();
            $table->double('price', 8, 2)->default(0);
            $table->double('total_price', 8, 2)->default(0);
            $table->double('cod_charges', 8, 2)->default(0);
            $table->double('shipping_rate', 8, 2)->default(0);
            $table->double('tax_per', 8, 2)->default(0);
            $table->double('taxable_price', 8, 2)->default(0);
            $table->string('discount_code')->comment('coupon code')->nullable();
            $table->double('discount_per', 8, 2)->default(0);
            $table->integer('total_quantity')->nullable();
            $table->string('order_number')->nullable();
            $table->string('payment_type')->default('cod');
            $table->string('payment_status', 32)->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_reference', 128)->nullable();
            $table->longText('razorpay_response')->nullable();
            $table->integer('order_status_id')->unsigned();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_headers');
    }
}
