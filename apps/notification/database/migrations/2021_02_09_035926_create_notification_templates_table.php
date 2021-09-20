<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('theme_ru')->comment('Тема сообщении');
            $table->string('theme_kz')->nullable()->comment('Тема сообщении');
            $table->string('theme_en')->nullable()->comment('Тема сообщении');
            $table->string('body_ru')->comment('Тело сообщении');
            $table->string('body_kz')->nullable()->comment('Тело сообщении');
            $table->string('body_en')->nullable()->comment('Тело сообщении');
            $table->string('hint')->nullable()->comment('Подсказка');
            $table->string('description')->nullable()->comment('Описание шаблона');
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
        Schema::dropIfExists('notification_templates');
    }
}
