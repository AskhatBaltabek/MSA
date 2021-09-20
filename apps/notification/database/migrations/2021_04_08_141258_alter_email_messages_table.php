<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEmailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_messages', function (Blueprint $table){
            $table->renameColumn('status', 'status_id');
            $table->unsignedBigInteger('template_id')->index()->nullable()->after('error')->comment('ID шаблона');

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
