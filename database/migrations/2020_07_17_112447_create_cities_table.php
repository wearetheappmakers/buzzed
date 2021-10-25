<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('state_id')->unsigned();
            $table->string('state_code');
            $table->integer('country_id')->unsigned();
            $table->string('country_code');
            $table->decimal('latitude',8,2);
            $table->decimal('longitude',8,2);
            $table->softDeletes('created_at', 0);
            $table->softDeletes('updated_on', 0);
            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
