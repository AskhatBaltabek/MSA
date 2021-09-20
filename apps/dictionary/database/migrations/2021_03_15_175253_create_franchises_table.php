<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('franchises'))
            return;

        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_commission')->comment('Агентское вознаграждение');
            $table->string('damage_title')->comment('Франшиза по повреждению');
            $table->float('damage_coef', '4', '4')->comment('Коэффициент по повреждению');
            $table->integer('damage_min_sum')->comment('Мин сумма по повреждению');
            $table->string('loss_title')->comment('Франшиза по утрате');
            $table->float('loss_coef', '4', '4')->comment('Коэффициент по утрате');
            $table->integer('loss_min_sum')->comment('Мин сумма по утрате');
            $table->float('kasko_without_amortization_coef', '4', '4')->comment('Каско (без амортизации)');
            $table->float('kasko_with_amortization_coef', '4', '4')->comment('Каско (с амортизацией)');
            $table->float('grand_kasko_amortization_coef', '4', '4')->comment('Гранд Каско');
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
        Schema::dropIfExists('franchises');
    }
}
