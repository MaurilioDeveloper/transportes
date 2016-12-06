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
        Route::get('/create', 'FreteController@create')->name('adicionarFrete');
        Route::get('/edit/{id}', 'FreteController@edit');
        Route::post('/cadastrar-frete', 'FreteController@store')->name('cadastrarFrete');
        Route::post('/postParceiro', 'FreteController@postParceiro')->name('postParceiro');
        Route::get('/', 'FreteController@index')->name('listarFretes');
    });


    //Parceiros
    Route::group(['prefix' => 'parceiros'], function(){
        Route::get('/delete-motorista/{id}', 'ParceiroController@deleteMotorista');
        Route::get('/listaParceiros', 'ParceiroController@listaParceiros')->name('listarParceiros');
        Route::post('/postOcorrencia', 'ParceiroController@postOcorrencia')->name('postOcorrencia');
        Route::get('/delete-parceiro/{id}', 'ParceiroController@deleteParceiro')->name('deleteParceiro');
        Route::get('/cadastrar', 'ParceiroController@cadastrar')->name('adicionarParceiro');
        Route::get('/edit/{id}', 'ParceiroController@edit')->name('editarParceiro');
    });

    Route::resource('parceiros', 'ParceiroController');



    //Usuários
    Route::resource('usuarios', 'UsuarioController');
    Route::get('delete-usuario/{id}', 'UsuarioController@destroy');
    Route::get('usuarios/listaUsuarios', 'UsuarioController@listaUsuarios');


    Route::get('/', 'PainelController@index')->name('dashboard');

});

Route::get('/login', function () {
    return view('auth.login');
});

$this->post('/login', 'Auth\LoginController@login');
$this->get('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');

