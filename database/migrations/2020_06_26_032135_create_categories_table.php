<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('on_home')->default(0);
            $table->integer('order')->default(0);
            $table->integer('position')->unsigned()->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
             
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
        Schema::dropIfExists('categories');
    }
}
