<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('ativo')->default(false);
            $table->unsignedInteger('user_parent_id')->nullable();
            $table->foreign('user_parent_id')->references('id')->on('users');
            $table->string('rg')->nullable();
            $table->timestamp('data_emissao')->nullable();
            $table->string('orgao_emissor')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->timestamp('data_nascimento')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('genero')->nullable();
            $table->string('profissao')->nullable();
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cep')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
