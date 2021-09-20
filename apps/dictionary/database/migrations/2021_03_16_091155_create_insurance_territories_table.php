<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceTerritoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('insurance_territories'))
            return;

        Schema::create('insurance_territories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->float('coefficient')->comment('Коэффициент');
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
        Schema::dropIfExists('insurance_territories');
    }
}
