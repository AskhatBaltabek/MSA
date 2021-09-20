<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('installments'))
            return;

        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('program_id')->comment('');
            $table->string('title')->comment('');
            $table->tinyInteger('months')->comment('');
            $table->float('coefficient')->comment('');
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
        Schema::dropIfExists('installments');
    }
}
