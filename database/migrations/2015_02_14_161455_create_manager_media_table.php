<?php

use Illuminate\Database\Migrations\Migration;

class CreateManagerMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laramedias', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('media_model');
            $table->integer('model_id')->unsigned();
            $table->string('file');
            $table->string('caption')->nullable();
            $table->string('credits')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('active')->default(1);

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
        Schema::drop('manager_medias');
    }
}
