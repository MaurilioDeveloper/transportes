<?php

use Illuminate\Database\Seeder;

class parceiro extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parceiros')->insert(array(
            array('tipo'=>'F','rg'=>'109982148','cpf'=>'05430939994','inscricaoEstadual'=>'','cnpj'=>'','endereco'=>'Rua Guilherme Bueno Franco','numero'=>'72','complemento'=>'casa','bairro'=>'tatuquara','cep'=>'81480337','cidade'=>'curitiba','estado'=>'PR','site'=>'wilterson.com.br'),
            array('tipo'=>'F','rg'=>'101232145','cpf'=>'02312378884','inscricaoEstadual'=>'','cnpj'=>'','endereco'=>'Av Visconde de Guarapuava','numero'=>'45','complemento'=>'Edificio 32','bairro'=>'Altoda XV','cep'=>'81350070','cidade'=>'curitiba','estado'=>'PR','site'=>'edificios.com.br'),
            array('tipo'=>'J','rg'=>'',         'cpf'=>''           ,'inscricaoEstadual'=>'123456789','cnpj'=>'123.456.789/0001-99','endereco'=>'Av das Nações','numero'=>'100','complemento'=>'sobrado','bairro'=>'Centro','cep'=>'81500322','cidade'=>'São Paulo','estado'=>'SP','site'=>'www.siteloko.com.br'),
            array('tipo'=>'J','rg'=>'',         'cpf'=>''           ,'inscricaoEstadual'=>'123456789','cnpj'=>'122.605.700/0001-90','endereco'=>'Rua Delegado Bruno de Almeida','numero'=>'7200','complemento'=>'Casa Comercial','bairro'=>'Boqueirao','cep'=>'81412457','cidade'=>'curitiba','estado'=>'PR','site'=>'www.cachorroloko.com.br'),
            array('tipo'=>'J','rg'=>'',         'cpf'=>''           ,'inscricaoEstadual'=>'123456789','cnpj'=>'120.125.652/0001-80','endereco'=>'Av 7 de Setembro','numero'=>'201','complemento'=>'Prédio Comercial','bairro'=>'Centro','cep'=>'80000000','cidade'=>'curitiba','estado'=>'PR','site'=>'www.tecmundo.com.br')
        ));
    }
}
