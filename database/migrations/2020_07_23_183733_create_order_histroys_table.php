<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHistroysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_histroys', function (Blueprint $table) {
            $table->integer('order_header_id')->unsigned();
            $table->integer('order_status_id')->unsigned();
            $table->timestamps();

            $table->primary(['order_header_id', 'order_status_id']);
            $table->foreign('order_header_id')->references('id')->on('order_headers')->onDelete('cascade');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_histroys');
    }
}
