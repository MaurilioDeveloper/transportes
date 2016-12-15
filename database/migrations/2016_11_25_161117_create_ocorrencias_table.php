<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcorrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocorrencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_ocorrencia')->unsigned();
            $table->foreign('id_tipo_ocorrencia')->references('id')->on('tipo_ocorrencias');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('parceiros');
            $table->integer('id_parceiro')->unsigned();
            $table->foreign('id_parceiro')->references('id')->on('parceiros');
            $table->date('data');
            $table->text('descricao');
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
        Schema::dropIfExists('ocorrencias');
    }
}
