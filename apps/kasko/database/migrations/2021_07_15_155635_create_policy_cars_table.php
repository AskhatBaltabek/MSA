<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_cars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('policy_id');
            $table->string('mark');
            $table->string('model');
            $table->integer('born');
            $table->string('number');
            $table->bigInteger('insurance_sum');
            $table->bigInteger('premium');
            $table->string('tf_id_esbd')->nullable();
            $table->string('color')->nullable();
            $table->string('engine_number')->nullable();
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
        Schema::dropIfExists('policy_cars');
    }
}
