<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterUsers2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $keyExists = DB::select(
            DB::raw('SHOW KEYS FROM users WHERE Key_name=\'users_iin_unique\''
            )
        );

        if(!$keyExists)
            return;

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_iin_unique');
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
