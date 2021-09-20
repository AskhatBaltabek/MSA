<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotificationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('products');

        Schema::table('notification_templates', function (Blueprint $table){
            $table->string('code', 50)->unique()->nullable()->after('id')->comment('Ключ шаблона');
            $table->longText('body_ru')->change();
            $table->longText('body_kz')->change();
            $table->longText('body_en')->change();
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
