<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSmsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_messages', function (Blueprint $table){
            $table->unsignedBigInteger('template_id')->index()->nullable()->after('error_msg')->comment('ID шаблона');
            $table->text('error_msg')->change();
            $table->renameColumn('error_msg', 'error');

            $table->foreign('template_id')->on('notification_templates')->references('id')->restrictOnDelete();
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
