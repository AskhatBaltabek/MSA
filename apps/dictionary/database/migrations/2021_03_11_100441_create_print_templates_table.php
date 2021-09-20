<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('print_templates'))
            return;

        Schema::create('print_templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->comment('ID продукта');
            $table->string('key')->comment('Ключ шаблона');
            $table->string('title')->comment('Название шаблона печатных форм');
            $table->longText('body_kz')->comment('Тело шаблона на казахском');
            $table->longText('body_ru')->comment('Тело шаблона на русском');
            $table->longText('body_en')->comment('Тело шаблона на английском');
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
        Schema::dropIfExists('print_templates');
    }
}
