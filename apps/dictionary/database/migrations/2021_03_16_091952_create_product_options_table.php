<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('product_options'))
            return;

        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id_1с')->comment('');
            $table->bigInteger('option_id')->comment('');
            $table->tinyInteger('checked')->default(0)->comment('');
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
        Schema::dropIfExists('product_options');
    }
}
