<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolicyCarsTable6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policy_cars', function (Blueprint $table) {
            if (!Schema::hasColumn('policy_cars', 'additional_list'))
                $table->string('additional_list')->nullable();
            if (!Schema::hasColumn('policy_cars', 'additional_sum'))
                $table->integer('additional_sum')->nullable();
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
