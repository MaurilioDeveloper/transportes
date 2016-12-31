<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viagens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_parceiro_viagem')->unsigned();
            $table->foreign('id_parceiro_viagem')->references('id')->on('parceiros');
            $table->integer('id_caminhao')->unsigned();
            $table->foreign('id_caminhao')->references('id')->on('caminhoes');
            $table->integer('id_motorista')->unsigned();
            $table->foreign('id_motorista')->references('id')->on('motoristas');
            $table->date('data_inicio');
            $table->time('horario_inicio');
            $table->date('data_fim');
            $table->time('horario_fim');
            $table->string('status');
            $table->integer('id_cidade_origem')->unsigned();
            $table->foreign('id_cidade_origem')->references('id')->on('origens_destinos');

            $table->integer('id_estado_origem')->unsigned();
            $table->foreign('id_estado_origem')->references('id')->on('origens_destinos');

            $table->integer('id_cidade_destino')->unsigned();
            $table->foreign('id_cidade_destino')->references('id')->on('origens_destinos');

            $table->integer('id_estado_destino')->unsigned();
            $table->foreign('id_estado_destino')->references('id')->on('origens_destinos');

            $table->integer('id_frete')->unsigned();
            $table->foreign('id_frete')->references('id')->on('fretes');
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
        Schema::dropIfExists('viagens');
    }
}
