<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Parceiros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parceiros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 1);
            $table->string('rg', 10);
            $table->string('cpf', 15);
            $table->string('inscricaoEstadual', 15);
            $table->string('cnpj', 25);
            $table->string('endereco');
            $table->integer('numero');
            $table->string('complemento');
            $table->string('bairro');
            $table->integer('cep');
            $table->string('cidade', 50);
            $table->string('estado', 2);
            $table->string('site', 50);
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
        Schema::dropIfExists('parceiros');
    }
}
