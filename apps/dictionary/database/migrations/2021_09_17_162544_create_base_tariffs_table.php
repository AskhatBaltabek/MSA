<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_tariffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('amount_sum')->nullable();
            $table->unsignedBigInteger('country_id')->index('country_id');
            $table->float('amount_premium', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_tariffs');
    }
}
