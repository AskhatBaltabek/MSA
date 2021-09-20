<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('insurance_risks', function (Blueprint $table) {
            $table->id()->comment('ID риска');
            $table->unsignedBigInteger('id_1c')->unique()->comment('ID риска (из справочника 1С)');
            $table->string('title')->comment('Название риска');
            $table->tinyInteger('active')->default(1)->comment('1 - активный, 0 - неактивный');
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
        Schema::dropIfExists('insurance_risks');
    }
}
