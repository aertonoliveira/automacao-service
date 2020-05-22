<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('title')->nullable();;
            $table->string('type')->nullable();;
            $table->string('icon')->nullable();;
//            $table->string('children')->nullable();
//            $table->foreign('children')->references('id')->on('menus');
            $table->unsignedInteger('children')->nullable();
            $table->foreign('children')->references('id')->on('users');
            $table->string('url')->nullable();;
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
        Schema::dropIfExists('menus');
    }
}
