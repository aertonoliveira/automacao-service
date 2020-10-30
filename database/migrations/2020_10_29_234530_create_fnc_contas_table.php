<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFncContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnc_contas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->decimal('valor', 10, 2);
            $table->date('data_vencimento');
            $table->boolean('situacao')->default(false);

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('registro_id')->nullable();
            $table->integer('tipo_registro');

            $table->char('tipo_conta', 1);

            $table->date('data_pagamento')->nullable();
            $table->string('comprovante')->nullable();
            
            $table->string('observacoes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fnc_contas');
    }
}
