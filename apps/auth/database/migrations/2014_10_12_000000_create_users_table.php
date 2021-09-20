<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('id_1c')->nullable();
            $table->integer('id_ext')->nullable();
            $table->string('login')->unique();
            $table->string('password');
            $table->string('email')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('iin')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('filial')->nullable();
            $table->integer('filial_id_1c')->nullable();
            $table->string('department')->nullable();
            $table->string('division')->nullable();
            $table->string('position')->nullable();
            $table->string('sales')->nullable();
            $table->boolean('resident')->default(1);
            $table->boolean('external')->default(0);
            $table->boolean('natural_person_bool')->default(1);
            $table->string('document_number')->nullable();
            $table->dateTime('document_start_date')->nullable();
            $table->dateTime('document_end_date')->nullable();
            $table->boolean('link_to_branch')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
