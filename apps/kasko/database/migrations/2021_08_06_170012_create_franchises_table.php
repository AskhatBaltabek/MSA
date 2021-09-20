<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_code');
            $table->float('tarif', 8, 4);
            $table->string('franchise_damage');
            $table->float('coef_damage', 8, 4);
            $table->integer('min_sum_damage');
            $table->string('franchise_loss');
            $table->float('coef_loss', 8, 4);
            $table->integer('min_sum_loss')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('franchises');
    }
}
