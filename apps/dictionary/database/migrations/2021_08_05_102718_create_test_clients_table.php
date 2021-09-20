<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('test_clients'))
            return;

        Schema::create('test_clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id');
            $table->bigInteger('iin');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->integer('natural_person_bool');
            $table->integer('class_id');
            $table->integer('sex_id');
            $table->date('born');
            $table->integer('resident_bool');
            $table->string('bonus_malus');
            $table->bigInteger('document_number');
            $table->date('document_gived_date');
            $table->integer('document_type_id');
            $table->integer('age_experience_id');
            $table->integer('priveleger_bool');
            $table->string('email');
            $table->bigInteger('phone');
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
        Schema::dropIfExists('test_clients');
    }
}
