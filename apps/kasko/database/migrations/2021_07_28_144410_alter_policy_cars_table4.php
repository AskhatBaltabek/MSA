<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolicyCarsTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policy_cars', function (Blueprint $table) {
            if (!Schema::hasColumn('policy_cars', 'mark_id'))
                $table->integer('mark_id');
            if (!Schema::hasColumn('policy_cars', 'model_id'))
                $table->integer('model_id');
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
