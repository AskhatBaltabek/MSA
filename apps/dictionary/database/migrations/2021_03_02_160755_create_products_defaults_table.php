<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsDefaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('products_defaults'))
            return;

        Schema::create('products_defaults', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id_1c')->comment('ID в 1С продукта');
            $table->string('default_key')->comment('Ключевое имя составляющего продукта');
            $table->bigInteger('default_id')->comment('ID в 1С составляющего');
            $table->tinyInteger('status')->comment('Статус. 1 - активный; 0 - неактивный');
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
        Schema::dropIfExists('products_defaults');
    }
}
