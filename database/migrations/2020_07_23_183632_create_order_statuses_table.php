<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('label')->nullable();
            $table->string('description')->nullable();
            $table->boolean('show_on_timeline')->default(1);
            $table->boolean('status')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
        DB::table('order_statuses')->insert(
            array(
                'name' => 'Waiting',
                'label' => "waiting",
                'description' => "Your order is Pending",
            )
        );
        DB::table('order_statuses')->insert(
            array(
                'name' => 'Preparing',
                'label' => "preparing",
                'description' => "Preparing to Order",
            )
        );
        DB::table('order_statuses')->insert(
            array(
                'name' => 'On the way',
                'label' => "ontheway",
                'description' => "Your order has been shipped",
            )
        );
        DB::table('order_statuses')->insert(
            array(
                'name' => 'Completed',
                'label' => "completed",
                'description' => "Your Order is Completed",
            )
        );
        DB::table('order_statuses')->insert(
            array(
                'name' => 'Cancelled',
                'label' => "canceled",
                'description' => "Cancel Order",
            )
        );
        DB::table('order_statuses')->insert(
            array(
                'name' => 'Returned',
                'label' => "returned",
                'description' => "Return to Order",
            )
        );
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses');
    }
}
