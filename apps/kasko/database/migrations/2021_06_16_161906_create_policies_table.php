<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('policy_number')->nullable();
            $table->string('policy_id_1c')->nullable();
            $table->string('policy_id_esbd')->nullable();
            $table->bigInteger('agent_id_1c')->default(0);
            $table->bigInteger('manager_id_1c')->default(0);
            $table->bigInteger('user_id_1c');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->bigInteger('tarif_id_1c');
            $table->float('tarif', 8, 2);
            $table->integer('premium');
            $table->string('franchise');
            $table->json('beneficiary');
            $table->json('options');
            $table->json('payments');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('policies');
    }
}
