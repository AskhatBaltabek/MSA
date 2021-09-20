<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceObjectsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('insurance_objects'))
            return;

        Schema::create('insurance_objects', function (Blueprint $table) {
            $table->id()->comment('ID объекта');
            $table->unsignedBigInteger('id_1c')->unique()->comment('ID объекта (из справочника 1С)');
            $table->string('title')->comment('Название объекта');
            $table->string('type')->default(0)->comment('Тип объекта');
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
        Schema::dropIfExists('insurance_objects');
    }
}
