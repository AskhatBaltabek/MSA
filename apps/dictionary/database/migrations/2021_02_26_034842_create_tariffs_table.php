<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('tariffs'))
            return;

        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->comment('ID программы')->constrained('programs');
            $table->integer('min')->comment('Минимум');
            $table->integer('max')->comment('Максимум');
            $table->float('value', 6, 2)->comment('Значение тарифа');
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
        Schema::dropIfExists('tariffs');
    }
}
