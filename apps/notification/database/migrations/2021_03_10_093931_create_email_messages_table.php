<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_messages', function (Blueprint $table) {
            $table->id();
            $table->string('send_from')->comment('От кого');
            $table->string('send_to')->comment('Кому');
            $table->string('title', 500)->comment('Заголовок');
            $table->longText('message')->comment('Текст сообщения');
            $table->json('attachments')->nullable()->comment('Файлы для отправки. JSON');
            $table->unsignedTinyInteger('status')->comment('0 - не отправлено, 1 - успешно отправлено, 2 - ошибка не отпралено')->default(0);
            $table->text('error')->nullable()->comment('Текст ошибки');
            $table->timestamp('sent_at')->nullable()->comment('Время отпраки');
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
        Schema::dropIfExists('email_messages');
    }
}
