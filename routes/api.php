<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'painel'], function(){

    //Fretes
    Route::group(['prefix' => 'fretes'], function(){
        Route::get('/busca-parceiro/{name}', 'FreteController@getFindParceiro')->name('buscaParceiro');
        Route::get('/lista-fretes', 'FreteController@listaFretes')->name('listaFretes');
        Route::get('/delete-frete/{id}', 'FreteController@deleteFrete')->name('deleteFrete');
        Route::get('/create', 'FreteController@create')->name('adicionarFrete');
        Route::get('/edit/{id}', 'FreteController@edit');
        Route::get('/busca-por-status/{status}', 'FreteController@buscaPorStatus');
        Route::post('/cadastrar-frete', 'FreteController@store')->name('cadastrarFrete');
        Route::post('/postParceiro', 'FreteController@postParceiro')->name('postParceiro');
        Route::any('/filtrar-frete', 'FreteController@filtrar')->name('filtrarFrete');
        Route::put('/update/{id}', 'FreteController@update')->name('updateFrete');
        Route::get('/', 'FreteController@index')->name('listarFretes');
    });

    //Tipo de Ocorrências
    Route::group(['prefix' => 'tipo-ocorrencias'], function(){
        Route::get('/lista-tipo-ocorrencias', 'TipoOcorrenciaController@listaTipoOcorrencias')->name('listaTipoOcorrencias');
        Route::get('/create', 'TipoOcorrenciaController@create')->name('adicionarTipoOcorrencia');
        Route::get('/edit/{id}', 'TipoOcorrenciaController@edit');
        Route::get('/delete-tipo-ocorrencia/{id}', 'TipoOcorrenciaController@delete');
        Route::put('/update/{id}', 'TipoOcorrenciaController@update')->name('updateTipoOcorrencia');
        Route::get('/', 'TipoOcorrenciaController@index')->name('listagemTO');
    });

    //Origens e Destinos (CIDADES-ESTADOS)
    Route::group(['prefix' => 'cidades-estados'], function(){
        Route::get('/create', 'OrigemDestinoController@create')->name('createCidadesEstados');
        Route::post('/cadastrar-CE', 'OrigemDestinoController@store')->name('cadastrarCidadesEstados');
        Route::put('/update/{id}', 'OrigemDestinoController@update')->name('updateCidadesEstados');
        Route::get('/edit/{id}', 'OrigemDestinoController@edit')->name('editCidadesEstados');
        Route::get('/lista-cidades-estados', 'OrigemDestinoController@listaCidadesEstados')->name('listaCidadesEstados');
        Route::get('/', 'OrigemDestinoController@index')->name('listaCidadesEstados');
    });

    //Parceiros
    Route::group(['prefix' => 'parceiros'], function(){
        Route::get('/delete-motorista/{id}', 'ParceiroController@deleteMotorista');
        Route::get('/listaParceiros', 'ParceiroController@listaParceiros')->name('listarParceiros');
        Route::get('/busca-parceiros/{pesquisa}', 'ParceiroController@buscaParceiros')->name('buscarParceiros');
//        Route::get('/buscaParceiros', 'ParceiroController@buscaParceiros')->name('buscarParceiros');
        Route::post('/pesquisar', 'ParceiroController@pesquisar')->name('pesquisarParceiro');
        Route::post('/postOcorrencia', 'ParceiroController@postOcorrencia')->name('postOcorrencia');
        Route::get('/editOcorrencia/{id}', 'ParceiroController@editOcorrencia')->name('editOcorrencia');
        Route::post('/updateOcorrencia', 'ParceiroController@postOcorrencia')->name('updateOcorrencia');
        Route::post('/postTipoOcorrencia', 'ParceiroController@postTipoOcorrencia')->name('postTipoOcorrencia');
        Route::get('/delete-ocorrencia/{id}', 'ParceiroController@deleteOcorrencia')->name('deleteOcorrencia');
        Route::get('/delete-parceiro/{id}', 'ParceiroController@deleteParceiro')->name('deleteParceiro');
        Route::get('/cadastrar', 'ParceiroController@cadastrar')->name('adicionarParceiro');
        Route::get('/edit/{id}', 'ParceiroController@edit')->name('editarParceiro');
    });

    Route::resource('parceiros', 'ParceiroController');



    //Viagens
    Route::group(['prefix' => 'viagens'], function(){
        Route::get('/create-edit', 'ViagemController@create')->name('cadastrarViagens');
        Route::get('/busca-parceiro/{name}', 'ViagemController@buscaParceiro')->name('buscaParceiro');
        Route::get('/busca-motorista/{id}', 'ViagemController@buscaMotorista')->name('buscaMotorista');
        Route::get('/busca-caminhao/{id}', 'ViagemController@buscaCaminhao')->name('buscaCaminhao');
        Route::get('/fretes-adicionados/{id}', 'ViagemController@fretesAdicionados')->name('fretesAdicionados');
        Route::get('/lista-fretes', 'ViagemController@listaFretes')->name('buscaParceiro');
        Route::get('/delete-viagem/{id}', 'ViagemController@deleteViagem')->name('deleteViagem');
        Route::post('/cadastrar-viagem', 'ViagemController@store')->name('cadastrarViagem');
        Route::get('/edit/{id}', 'ViagemController@edit')->name('editarViagem');
        Route::put('/update/{id}', 'ViagemController@update')->name('updateViagem');
        Route::get('/busca-dados/{id}', 'ViagemController@dadosViagem');
        Route::get('/', 'ViagemController@index')->name('listaViagens');
    });

    //Usuários
    Route::get('delete-usuario/{id}', 'UsuarioController@destroy');
    Route::get('usuarios/listaUsuarios', 'UsuarioController@listaUsuarios');
    Route::get('usuarios/edit/{id}', 'UsuarioController@edit')->name('editarUsuario');
    Route::resource('usuarios', 'UsuarioController');

    //Dashboard
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index');


});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/uploadfile', 'FileuploadingController@index');
Route::post('/uploadfile', 'FileuploadingController@showfileupload');


$this->post('/login', 'Auth\LoginController@login');
$this->get('/logout', 'Auth\LoginController@logout');

Auth::routes();

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
