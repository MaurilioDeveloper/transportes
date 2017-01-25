<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFretesViagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fretes_viagens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_frete')->unsigned();
            $table->foreign('id_frete')->references('id')->on('fretes');
            $table->integer('id_viagem')->unsigned();
            $table->foreign('id_viagem')->references('id')->on('viagens');
            $table->double('custos');
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
        Schema::dropIfExists('fretes_viagens');
    }
}
