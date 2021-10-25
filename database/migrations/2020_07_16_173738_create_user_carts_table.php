<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('color_id')->unsigned();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->integer('size_id')->unsigned()->nullable();
            $table->string('product_name')->nullable();
            $table->string('size')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->string('currency')->nullable();
            $table->double('main_price', 8, 2)->default(0);
            $table->double('price', 8, 2)->default(0);
            $table->double('total_price', 8, 2)->default(0);
            $table->double('product_discount_per', 8, 2)->default(0);
            $table->string('discount_code')->comment('coupon code')->nullable();
            $table->double('discount_per', 8, 2)->default(0);
            $table->integer('quantity');
            $table->integer('total_quantity');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('restrict');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_carts');
    }
}
