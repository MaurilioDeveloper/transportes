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

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'painel'], function(){

    //Fretes
    Route::get('fretes/', 'FreteController@index')->name('listarFretes');
    Route::get('fretes/add', 'FreteController@create')->name('adicionarFrete');
    Route::get('fretes/edit/{id?}', 'FreteController@edit')->name('editarFrete');

    //Parceiros
    Route::get('parceiros/', 'ParceiroController@index')->name('listarParceiros');
    Route::get('parceiros/add', 'ParceiroController@create')->name('adicionarParceiro');
    Route::get('parceiros/edit/{id}', 'ParceiroController@edit')->name('editarParceiro');




    //Usuários
    Route::resource('usuarios', 'UsuarioController');
    Route::get('delete-usuario/{id}', 'UsuarioController@destroy');
    Route::get('usuarios/listaUsuarios', 'UsuarioController@listaUsuarios');

    //Pessoas
    Route::resource('pessoas', 'PessoaController');
    Route::get('/', 'PainelController@index')->name('dashboard');

});

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();