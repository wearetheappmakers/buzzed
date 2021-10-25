<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->double('discount_per', 8, 2);
            $table->string('discount_code')->nullable();
            $table->dateTime('discount_start_date',0);
            $table->dateTime('discount_end_date',0);
            $table->integer('order')->default(0);           
            $table->boolean('status')->default(1);
            $table->string('discount_for')->nullable()->comment('user for user special discount');
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('discounts');
    }
}
