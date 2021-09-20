<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolicyCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policy_cars', function (Blueprint $table){
            if(!Schema::hasColumn('policy_cars', 'passport_date'))
                $table->string('passport_date');
            if(!Schema::hasColumn('policy_cars', 'passport_number'))
                $table->integer('passport_number');
            if(!Schema::hasColumn('policy_cars', 'registration_region_id'))
                $table->bigInteger('registration_region_id');
            if(!Schema::hasColumn('policy_cars', 'vin'))
                $table->bigInteger('vin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
