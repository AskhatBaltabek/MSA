<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20);
            $table->string('message', 500);
            $table->string('sender', 255)->nullable();
            $table->string('sms_id', 20)->nullable();
            $table->integer('status_id')->default(0);
            $table->integer('status_code')->nullable();
            $table->string('error_msg', 500)->nullable();
            $table->timestampTz('sent_date')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_messages');
    }
}
