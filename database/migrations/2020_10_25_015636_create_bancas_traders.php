<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancasTraders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancas_traders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('banca_id');
            $table->foreign('banca_id')->references('id')->on('bancas');
            $table->decimal('valor_pago', 10, 2);
            $table->string('comprovante');
            $table->date('data_pagamento');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('bancas_traders');
    }
}
