<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'painel'], function(){

    //Fretes
    Route::group(['prefix' => 'fretes'], function(){
        Route::get('/busca-parceiro/{name}', 'FreteController@getFindParceiro')->name('buscaParceiro');
        Route::get('/lista-fretes', 'FreteController@listaFretes')->name('listaFretes');
        Route::get('/delete-frete/{id}', 'FreteController@deleteFrete')->name('deleteFrete');
        Route::get('/create', 'FreteController@create')->name('adicionarFrete');
        Route::get('/edit/{id}', 'FreteController@edit');
        Route::post('/cadastrar-frete', 'FreteController@store')->name('cadastrarFrete');
        Route::post('/postParceiro', 'FreteController@postParceiro')->name('postParceiro');
        Route::put('/update/{id}', 'FreteController@update')->name('updateFrete');
        Route::get('/', 'FreteController@index')->name('listarFretes');
    });


    //Parceiros
    Route::group(['prefix' => 'parceiros'], function(){
        Route::get('/delete-motorista/{id}', 'ParceiroController@deleteMotorista');
        Route::get('/listaParceiros', 'ParceiroController@listaParceiros')->name('listarParceiros');
        Route::get('/busca-parceiros/{pesquisa}', 'ParceiroController@buscaParceiros')->name('buscarParceiros');
//        Route::get('/buscaParceiros', 'ParceiroController@buscaParceiros')->name('buscarParceiros');
        Route::post('/pesquisar', 'ParceiroController@pesquisar')->name('pesquisarParceiro');
        Route::post('/postOcorrencia', 'ParceiroController@postOcorrencia')->name('postOcorrencia');
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

$this->post('/login', 'Auth\LoginController@login');
$this->get('/logout', 'Auth\LoginController@logout');

//Auth::routes();


