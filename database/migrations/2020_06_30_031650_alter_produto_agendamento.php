<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProdutoAgendamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contrato_mutuos', function (Blueprint $table) {
            $table->timestamp('agendamento_relatorio')->nullable();
            $table->decimal('valor_atualizado')->nullable();
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
            $table->dropColumn('agendamento_relatorio');
            $table->dropColumn('valor_atualizado');
        });
    }
}
