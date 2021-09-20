<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductSettings2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_settings', function (Blueprint $table){
            if(!Schema::hasColumn('products_settings', 'position'))
                $table->integer('position')->after('value')->default(0);
            if(!Schema::hasColumn('products_settings', 'enable'))
                $table->tinyInteger('enable')->after('value')->default(1);
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
