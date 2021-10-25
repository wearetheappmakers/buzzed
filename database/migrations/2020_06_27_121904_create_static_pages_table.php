<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('type');
            $table->string('slug')->index();
            $table->string('banner_image')->nullable();
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('order')->default(0);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->unique(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('static_pages');
    }
}
