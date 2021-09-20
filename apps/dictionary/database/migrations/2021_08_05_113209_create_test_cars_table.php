<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('test_cars'))
            return;

        Schema::create('test_cars', function (Blueprint $table) {
            $table->id();
            $table->integer('tf_id');
            $table->integer('type_id');
            $table->string('vin');
            $table->string('reg_num');
            $table->string('reg_cert_num');
            $table->date('dt_reg_cert');
            $table->integer('nyear');
            $table->integer('region_id');
            $table->integer('big_city_bool');
            $table->string('model');
            $table->string('mark');
            $table->string('color');
            $table->string('engine_number');
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
        Schema::dropIfExists('test_cars');
    }
}
