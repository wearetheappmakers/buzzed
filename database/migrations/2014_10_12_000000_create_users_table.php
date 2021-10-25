<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('is_active')->default(0);
            $table->string('fullname');
            $table->string('email');
            $table->string('number');
            $table->string('landline');
            $table->string('bussiness_name');
            $table->string('billing_name');
            $table->longText('billing_address');
            $table->integer('billing_country_id');
            $table->integer('billing_state_id');
            $table->integer('billing_cities_id');
            $table->integer('is_same')->default(0);
            $table->longText('dispatch_address')->nullable();
            $table->integer('dispatch_country_id')->nullable();
            $table->integer('dispatch_state_id')->nullable();
            $table->integer('dispatch_cities_id')->nullable();
            $table->string('gst_no');
            $table->integer('type_of_bussiness')->comment('1=Proprietor, 2=Partnership, 3=LLP, 4=Pvt. Ltd.)');
            $table->integer('no_of_partner_value')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('agent_company_name')->nullable();
            $table->string('agent_registration_no')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
