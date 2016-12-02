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

    //Contatos
//    Route::get('parceiros/delete-motorista/{id}', 'ParceiroController@deleteMotorista');

    //Parceiros
    Route::get('parceiros/listaParceiros', 'ParceiroController@listaParceiros')->name('listarParceiros');
//    Route::post('parceiros/postOcorrencia', 'ParceiroController@postOcorrencia')->name('postOcorrencia');
//    Route::get('parceiros/delete-parceiro/{id}', 'ParceiroController@deleteParceiro')->name('deleteParceiro');
    Route::get('parceiros/cadastrar', 'ParceiroController@cadastrar')->name('adicionarParceiro')->middleware('auth');
    Route::get('parceiros/edit/{id}', 'ParceiroController@edit')->name('editarParceiro');
//    Route::get('parceiros', 'ParceiroController@index')->name('parceiros');

//    Route::get('parceiros/cadastrar', 'ParceiroController@create')->name('adicionarParceiro');
//    Route::get('parceiros/edit/{id}', 'ParceiroController@edit')->name('editarParceiro');
    Route::resource('parceiros', 'ParceiroController');
//    Route::get('parceiros', 'ParceiroController@index')->name('listaParceiro')->middleware('auth');



    //Usuários
    Route::resource('usuarios', 'UsuarioController');
    Route::get('delete-usuario/{id}', 'UsuarioController@destroy');
    Route::get('usuarios/listaUsuarios', 'UsuarioController@listaUsuarios');

    //Pessoas
//    Route::resource('pessoas', 'PessoaController');
    Route::get('/', 'PainelController@index')->name('dashboard');

});

Route::get('/login', function () {
    return view('auth.login');
});

$this->post('/login', 'Auth\LoginController@login');
$this->get('/logout', 'Auth\LoginController@logout');

Auth::routes();
Auth::routes();

Route::get('/home', 'HomeController@index');
