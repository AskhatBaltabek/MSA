<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEconomicsSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('economics_sectors'))
            return;

        Schema::create('economics_sectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_esbd');
            $table->unsignedBigInteger('parent_id_esbd');
            $table->string('title',500);
            $table->integer('code');
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
        Schema::dropIfExists('economics_sectors');
    }
}
