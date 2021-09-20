<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('insurance_types'))
            return;

        Schema::create('insurance_types', function (Blueprint $table) {
            $table->id()->comment('ID вида страхования');
            $table->unsignedBigInteger('id_1c')->unique()->comment('ID вида страхования (из справочника 1С)');
            $table->string('title')->comment('Название риска');
            $table->string('serial_number')->comment('Код вида страхования(serialNumber)');
            $table->tinyInteger('obligate')->default(0)->comment('Вид типа страхования: 1 - обязательный, 0 - добровольный.');
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
        Schema::dropIfExists('insurance_types');
    }
}
