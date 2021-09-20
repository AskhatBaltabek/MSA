<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('products_relations'))
            return;

        Schema::create('products_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id_1c')->comment('ID в 1С продукта');
            $table->unsignedBigInteger('insurance_risk_id_1c')->comment('ID в 1С риска');
            $table->unsignedBigInteger('insurance_object_id_1c')->comment('ID в 1С объекта');
            $table->unsignedBigInteger('insurance_type_id_1c')->comment('ID в 1С вида страхования');
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
        Schema::dropIfExists('products_relations');
    }
}
