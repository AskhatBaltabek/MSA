<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('policy_id');
            $table->string('fio');
            $table->bigInteger('iin');
            $table->string('address')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('born')->nullable();
            $table->string('phone')->nullable();
            $table->string('document_gived_by')->nullable();
            $table->string('document_gived_date')->nullable();
            $table->string('document_number')->nullable();
            $table->integer('document_type_id')->nullable();
            $table->boolean('natural_person_bool')->default(1);
            $table->boolean('resident_bool')->default(1);
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
        Schema::dropIfExists('clients');
    }
}
