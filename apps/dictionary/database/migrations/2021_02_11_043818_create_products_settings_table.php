<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('products_settings'))
            return;

        Schema::create('products_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id_1c')->comment('ID продукта в 1С')->nullable();
            $table->bigInteger('program_id')->comment('ID программы')->nullable();
            $table->string('title')->comment('Наименование настройки');
            $table->text('description')->comment('Описание настройки')->nullable();
            $table->string('key')->comment('Ключ настройки продукта');
            $table->string('value')->comment('Значение настройки продукта');
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
        Schema::dropIfExists('products_settings');
    }
}
