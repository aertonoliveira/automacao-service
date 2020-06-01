<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoMutuosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_mutuos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('porcentagem')->nullable();
            $table->decimal('valor')->nullable();
            $table->integer('tempo_contrato')->nullable();
            $table->date('inicio_mes')->nullable();
            $table->date('final_mes')->nullable();
            $table->boolean('ativo')->default(false);
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('contrato_mutuos');
    }
}
