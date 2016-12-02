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
            $table->date('data_hoje');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('origem');
            $table->string('destino');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('tipo');
            $table->string('identificacao');
            $table->double('valor_item');
            $table->string('cor');
            $table->integer('id_parceiro_coletor')->unsigned()->nullable();
            $table->foreign('id_parceiro_coletor')->references('id')->on('parceiros');
            $table->double('valor_coleta')->nullable();
            $table->integer('id_parceiro_entregador')->unsigned()->nullable();
            $table->foreign('id_parceiro_entregador')->references('id')->on('parceiros');
            $table->double('valor_entrega')->nullable();
            $table->double('valor_total');
            $table->text('informacoes_complementares');
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
