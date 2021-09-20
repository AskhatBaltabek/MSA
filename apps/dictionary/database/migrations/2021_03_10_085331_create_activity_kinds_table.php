<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityKindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('activity_kinds'))
            return;

        Schema::create('activity_kinds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_esbd');
            $table->unsignedBigInteger('parent_id_esbd')->nullable();
            $table->string('title',500);
            $table->string('code');
            $table->timestamps();
            $table->index('id_esbd');
            $table->index('parent_id_esbd');
            $table->foreign('parent_id_esbd')->references('id_esbd')->on('activity_kinds')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_kinds');
    }
}
