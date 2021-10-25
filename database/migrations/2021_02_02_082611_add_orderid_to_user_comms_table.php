<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderidToUserCommsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_comms', function (Blueprint $table) {
            $table->Integer('order_id')->unsigned()->nullable()->after('product_id');
            $table->foreign('order_id')->references('id')->on('order_headers')->onDelete('cascade')->update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_comms', function (Blueprint $table) {
            //
        });
    }
}
