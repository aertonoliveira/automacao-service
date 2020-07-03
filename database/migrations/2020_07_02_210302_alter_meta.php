<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meta_clientes', function (Blueprint $table) {
            $table->boolean('ativo')->default(false)->nullable();
            $table->double('meta_individual')->nullable();
            $table->double('meta_equipe')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meta_clientes', function (Blueprint $table) {
            $table->dropColumn('ativo');
            $table->dropColumn('meta_individual')->nullable();
            $table->dropColumn('meta_equipe')->nullable();
        });
    }
}
