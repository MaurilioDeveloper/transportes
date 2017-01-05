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
            $table->integer('id_caminhao')->unsigned()->nullable();
            $table->foreign('id_caminhao')->references('id')->on('caminhoes')->onUpdate('cascade');;
            $table->integer('id_motorista')->unsigned()->nullable();
            $table->foreign('id_motorista')->references('id')->on('motoristas')->onUpdate('cascade');;
            $table->date('data_inicio')->nullable();
            $table->time('horario_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->time('horario_fim')->nullable();
            $table->string('status');
            $table->integer('id_cidade_origem')->unsigned();
            $table->foreign('id_cidade_origem')->references('id')->on('origens_destinos');

            $table->integer('id_cidade_destino')->unsigned();
            $table->foreign('id_cidade_destino')->references('id')->on('origens_destinos');

            $table->string('informacoes_complementares')->nullable();

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
