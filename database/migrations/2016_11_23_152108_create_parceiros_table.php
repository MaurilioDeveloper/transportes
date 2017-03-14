<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParceirosTable extends Migration
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
            $table->string('nome');
            $table->string('documento')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->date('data_nasc')->nullable();
            $table->char('sexo')->nullable();
            /*
             * Atribui o array numero de informações para o Estado Civil
             * atraves do 'enum' e da CONSTANTE declarada (ESTADOS_CIVIS)
             *
             */
            $table->enum('estado_civil', array_keys(App\Models\Parceiro::ESTADOS_CIVIS))->nullable();
            $table->string('deficiencia_fisica')->nullable();
            // Nome Popular da empresa.. Campo não obrigatório, pode ser NULL
            $table->string('fantasia')->nullable();
            $table->string('inscricao_estadual', 15)->nullable();
            $table->string('endereco')->nullable();
            $table->integer('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('site', 50)->nullable();
            $table->string('pessoa');
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
