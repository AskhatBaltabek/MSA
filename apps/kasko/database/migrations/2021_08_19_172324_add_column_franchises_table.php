<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFranchisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('franchises', function (Blueprint $table){
            if(!Schema::hasColumn('franchises', 'operator_damage'))
                $table->string('operator_damage')->after('coef_damage')->nullable();
            if(!Schema::hasColumn('franchises', 'operator_loss'))
                $table->string('operator_loss')->after('coef_loss')->nullable();
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
