<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('products'))
            return;

        Schema::create('products', function (Blueprint $table) {
            $table->id()->comment('ID продукта');
            $table->string('title')->comment('Название продукта');
            $table->string('code')->comment('Код продукта (из справочника 1С)');
            $table->unsignedBigInteger('id_1c')->unique()->comment('ID продукта (из справочника 1С)');
            $table->tinyInteger('obligate')->default(0)->comment('Вид продукта: 1 - обязательный, 0 - добровольный.');
            $table->tinyInteger('complex')->default(0)->comment('1 - Комплексный продукт, 0 - Не комплексный продукт');
            $table->tinyInteger('not_quoted')->default(0)->comment('1 - Комплексный продукт, 0 - Не комплексный продукт');
            $table->tinyInteger('prolongation_type')->default(1);
            $table->tinyInteger('active')->default(1)->comment('1 - активный, 0 - неактивный');
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
        Schema::dropIfExists('products');
    }
}
