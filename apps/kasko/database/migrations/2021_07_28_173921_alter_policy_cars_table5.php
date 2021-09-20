<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolicyCarsTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policy_cars', function (Blueprint $table) {
            if (!Schema::hasColumn('policy_cars', 'cost'))
                $table->integer('cost')->nullable();
            if (!Schema::hasColumn('policy_cars', 'is_bu'))
                $table->boolean('is_bu')->default(0);
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
