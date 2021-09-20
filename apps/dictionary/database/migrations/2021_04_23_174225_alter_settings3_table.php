<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettings3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if(Schema::hasColumn('settings', 'title'))
                $table->string('title')->default('')->change();

            if(Schema::hasColumn('settings', 'value'))
                $table->dropColumn('value');

            if(!Schema::hasColumn('settings', 'updated_at'))
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
        //
    }
}
