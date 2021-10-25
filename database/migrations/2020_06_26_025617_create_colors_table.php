<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->index();
            $table->string('code')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('order')->default(0);
            $table->softDeletes('deleted_at', 0);
            
            $table->unique(['slug']);
             
            $table->timestamps();
        });
        DB::table('colors')->insert(
            array(
                'name' => "no",
                'slug' => "no",
                'code' => "no",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
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
        Schema::dropIfExists('colors');
    }
}
