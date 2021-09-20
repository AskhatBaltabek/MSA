<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if(!Schema::hasColumn('settings', 'key'))
                $table->string('key')->comment('Ключ настройки для вызова из кода');
            if(!Schema::hasColumn('settings', 'setting'))
                $table->json('setting')->comment('Тело настройки. Может быть массив. Пример: {"name":"example-setting", "value": "100", "type": "number" }')->nullable();
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
