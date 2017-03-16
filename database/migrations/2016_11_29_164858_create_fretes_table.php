<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFretesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fretes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_parceiro')->unsigned();
            $table->foreign('id_parceiro')->references('id')->on('parceiros');
            $table->date('data_hoje')->nullable();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->integer('id_cidade_origem')->unsigned();
            $table->foreign('id_cidade_origem')->references('id')->on('origens_destinos');

            $table->integer('id_cidade_destino')->unsigned();
            $table->foreign('id_cidade_destino')->references('id')->on('origens_destinos');

            $table->integer('id_cidade_localizacao')->unsigned();
            $table->foreign('id_cidade_localizacao')->references('id')->on('origens_destinos');

            $table->string('tipo')->nullable();
            $table->string('identificacao')->nullable();
            $table->string('chassi', 100)->nullable();
            $table->string('valor_item');
            $table->string('cor')->nullable();
            $table->string('status');
            $table->string('iscoleta')->nullable();
            $table->integer('id_parceiro_coletor')->unsigned()->nullable();
            $table->foreign('id_parceiro_coletor')->references('id')->on('parceiros');
            $table->string('valor_coleta')->nullable();
            $table->string('isentrega')->nullable();
            $table->integer('id_parceiro_entregador')->unsigned()->nullable();
            $table->foreign('id_parceiro_entregador')->references('id')->on('parceiros');
            $table->string('valor_entrega')->nullable();
            $table->string('valor_total')->nullable();
            $table->string('image')->nullable();
            $table->text('informacoes_complementares')->nullable();
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
        Schema::dropIfExists('fretes');
    }
}
