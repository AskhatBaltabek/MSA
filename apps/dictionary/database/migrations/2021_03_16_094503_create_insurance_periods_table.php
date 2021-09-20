<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('insurance_periods'))
            return;

        Schema::create('insurance_periods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('program_id')->comment('');
            $table->string('title')->comment('');
            $table->float('coefficient')->comment('')->nullable();
            $table->tinyInteger('max_payments')->comment('')->nullable();
            $table->float('max_tariff')->comment('')->nullable();
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
        Schema::dropIfExists('insurance_periods');
    }
}
