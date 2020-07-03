<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterComissao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comissaos', function (Blueprint $table) {
            $table->timestamp('data_pagamento')->nullable();
            $table->double('valor_pagamento_atual')->nullable();
            $table->double('valor_pagamento_meta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comissaos', function (Blueprint $table) {
            $table->dropColumn('data_pagamento');
            $table->dropColumn('valor_pagamento_atual');
            $table->dropColumn('valor_pagamento_meta');
        });
    }
}
