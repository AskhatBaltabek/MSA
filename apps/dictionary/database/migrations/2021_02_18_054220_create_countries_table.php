<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('countries'))
            return;

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id')->unique()->comment('ID страны в ЕСБД');
            $table->string('title')->comment('Название страны');
            $table->integer('code')->comment('Код страны')->nullable();
            $table->foreignId('program_id')->comment('ID программы')->default(1)->constrained('programs');
            $table->foreignId('currency_id')->comment('ID валюты')->default(2)->constrained('currencies');
            $table->bigInteger('multiply')->comment('Умножение премии')->default(1);
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
        Schema::dropIfExists('countries');
    }
}
