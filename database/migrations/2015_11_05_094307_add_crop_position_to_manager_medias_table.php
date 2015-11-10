<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCropPositionToManagerMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manager_medias', function (Blueprint $table) {
            $table->string('crop_position', 20)->nullable()->default(null)->default('center')->after('credits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manager_medias', function (Blueprint $table) {
            $table->dropColumn('crop_position');
        });
    }
}
