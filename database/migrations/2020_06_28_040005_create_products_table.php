<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('product_type', ['1', '2', '3', '4'])->comment('1 = No Color No Size, 2= No Color, 3 = NO Size, 4 = Both');
            $table->string('product_code');
            $table->string('sku');
            $table->string('hsn_code')->nullable();
            $table->string('included_components')->nullable();
            $table->string('legal_desclaimers')->nullable();
            $table->string('item_type_name')->nullable();
            $table->string('product_tax_code')->nullable();
            $table->integer('moq')->nullable()->comment('Maximum Order Qunatity');
            $table->string('name');
            $table->string('sizechart')->nullable();
            $table->longText('description')->nullable();
            $table->longText('bullet_point_1')->nullable();
            $table->longText('bullet_point_2')->nullable();
            $table->longText('bullet_point_3')->nullable();
            $table->longText('bullet_point_4')->nullable();
            $table->longText('bullet_point_5')->nullable();
            $table->integer('number_of_pieces')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('igst')->default(0);
            $table->boolean('manage_stock')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('is_new')->default(0);
            $table->boolean('is_home')->default(0);
            $table->integer('order')->default(0);
            $table->string('slug')->unique();
             
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
