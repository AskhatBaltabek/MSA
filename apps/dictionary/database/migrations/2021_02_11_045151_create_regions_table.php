<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('regions'))
            return;

        Schema::create('regions', function (Blueprint $table) {
            $table->id()->comment('ID региона');
            $table->string('title')->comment('Название региона');
            $table->unsignedBigInteger('regions_id')->nullable()->comment('ID региона');
            $table->float('coef')->nullable()->comment('Коэфицент региона');
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
        Schema::dropIfExists('regions');
    }
}
