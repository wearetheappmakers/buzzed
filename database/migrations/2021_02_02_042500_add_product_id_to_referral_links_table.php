<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductIdToReferralLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referral_links', function (Blueprint $table) {
            $table->Integer('product_id')->unsigned()->nullable()->after('user_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral_links', function (Blueprint $table) {
            //
        });
    }
}
