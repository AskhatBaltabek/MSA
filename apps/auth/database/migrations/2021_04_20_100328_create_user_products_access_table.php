<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProductsAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_products_access', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('product_id');
            $table->integer('sales_channel_id_1c');
            $table->integer('detailing_id_1c');
            $table->boolean('online');
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
