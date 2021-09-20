<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBaseTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_tariffs', function (Blueprint $table) {
            $table->foreign('country_id', 'FK_base_tariffs_countries')->references('country_id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('base_tariffs', function (Blueprint $table) {
            $table->dropForeign('FK_base_tariffs_countries');
        });
    }
}
