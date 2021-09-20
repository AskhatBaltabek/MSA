<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoliciesTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policies', function (Blueprint $table){
            if(!Schema::hasColumn('policies', 'franchise_damage'))
                $table->string('franchise_damage');
            if(!Schema::hasColumn('policies', 'franchise_loss'))
                $table->string('franchise_loss');
            if(Schema::hasColumn('policies', 'franchise'))
                $table->dropColumn('franchise');
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
