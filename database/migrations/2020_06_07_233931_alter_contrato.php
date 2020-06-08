<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('contrato_mutuos', function (Blueprint $table) {
            $table->string('numero_contrato')->unique()->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrato_mutuos', function (Blueprint $table) {
            $table->dropColumn('numero_contrato');
        });
    }
}
