<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policies', function (Blueprint $table){
            if(!Schema::hasColumn('policies', 'sales_channel_id_1c'))
                $table->bigInteger('sales_channel_id_1c')->after('user_id_1c')->nullable();
            if(!Schema::hasColumn('policies', 'detailing_id_1c'))
                $table->bigInteger('detailing_id_1c')->after('user_id_1c')->nullable();
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
