<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsers3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            if(!Schema::hasColumn('users', 'filial_id_1c'))
                $table->integer('filial_id_1c')->nullable()->after('filial');
            if(!Schema::hasColumn('users', 'sales'))
                $table->string('sales')->nullable()->after('position');
            if(!Schema::hasColumn('users', 'document_number'))
                $table->string('document_number')->nullable()->after('external');
            if(!Schema::hasColumn('users', 'document_start_date'))
                $table->dateTime('document_start_date')->nullable()->after('external');
            if(!Schema::hasColumn('users', 'document_end_date'))
                $table->dateTime('document_end_date')->nullable()->after('external');
            if(!Schema::hasColumn('users', 'link_to_branch'))
                $table->boolean('link_to_branch')->default(0)->after('external');
            if(!Schema::hasColumn('users', 'email_verified_at'))
                $table->timestamp('email_verified_at')->nullable()->after('external');
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
