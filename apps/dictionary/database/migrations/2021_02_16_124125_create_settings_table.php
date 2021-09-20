<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('settings'))
            return;

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Название настройки');
            $table->string('key')->comment('Ключ настройки для вызова из кода');
            $table->json('setting')->comment('Тело настройки. Может быть массив. Пример: {"name":"example-setting", "value": "100", "type": "number" }')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
