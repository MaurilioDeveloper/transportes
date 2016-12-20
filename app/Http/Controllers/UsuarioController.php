<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Datatables;

class UsuarioController extends Controller
{

    private $user;

    private $request;

    public function __construct(User $user, Request $request) {
        $this->user = $user;
        $this->request = $request;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = $this->user->get();
//        dd($usuarios);
        $titulo = "Listagem de Usuario";
        return view('painel.usuarios.index2', compact('titulo', 'usuarios'));
    }

    public function listaUsuarios(){
        //  dd(Datatables::of(Visita::query())->make(true));
        return Datatables::of(User::query()
            ->select("users.name", "users.email", "users.id"))->make(true);
//        return User::query()->select("users.name", "users.email")->get();
    }

    public function editUsuarios($id)
    {
        $dadosForm = $this->request->all();
        $usuario = $this->user->find($id);
        //$this->authorize('update-user', $usuario);

        // Regras para Edição
        $rules =  [
            'name' => 'required|min:3|max:100',
            'email' => "required|min:4|unique:users,email,{$id}",
            'password' => "required",
        ];
//        dd($rules);
        $validator = validator($dadosForm, $rules);

        if( $validator->fails() ){
            return redirect("/painel/usuarios/{$id}/edit")
                ->withErrors($validator)
                ->withInput();
        }

        if(count($dadosForm['password']) > 0){
            $dadosForm['password'] = bcrypt($dadosForm['password']);
        }else{
            unset($dadosForm['password']);
        }

        $update = $usuario->update($dadosForm);
        if( $update ){
            return redirect('/painel/usuarios');
        }
        return redirect("/painel/usuarios/{$id}/edit")
            ->withErrors('errors', 'Falha ao Editar');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titulo = "Cadastro de Usuários";
        return view('painel.usuarios.create-edit', compact('titulo'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
//        dd($request->input('email'));
//        dd($request->only(['email', 'password']));
//        dd($request->except(['email', 'password']));
        $dadosForm = $this->request->all();

        $validator = validator($dadosForm, User::$rules);

        if( $validator->fails() ){
            return redirect('/painel/usuarios/create')
                ->withErrors($validator)
                ->withInput();
        }

        $dadosForm['password'] = bcrypt($dadosForm['password']);


        $insert = $this->user->create($dadosForm);
        if( $insert ){
            return redirect('/painel/usuarios');
        }
        return redirect("/painel/usuarios/create")
            ->withErrors('errors', 'Falha ao Cadastrar');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = $this->user->find($id);

        return view('painel.usuarios.create-edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dadosForm = $this->request->all();
        $usuario = $this->user->find($id);
        //$this->authorize('update-user', $usuario);

        // Regras para Edição
        $rules =  [
            'name' => 'required|min:3|max:100',
            'email' => "required|min:4|unique:users,email,{$id}",
            'password' => "required",
        ];
//        dd($rules);
        $validator = validator($dadosForm, $rules);

        if( $validator->fails() ){
            return redirect("/painel/usuarios/{$id}/edit")
                ->withErrors($validator)
                ->withInput();
        }

        if(count($dadosForm['password']) > 0){
            $dadosForm['password'] = bcrypt($dadosForm['password']);
        }else{
            unset($dadosForm['password']);
        }

        $update = $usuario->update($dadosForm);
        if( $update ){
            return redirect('/painel/usuarios');
        }
        return redirect("/painel/usuarios/{$id}/edit")
            ->withErrors('errors', 'Falha ao Editar');

        // dd($update);
    }

    public function pesquisar()
    {
        $palavraPesquisa = $this->request->get('pesquisar');


        $data = $this->user
            ->where('name', 'LIKE', "%$palavraPesquisa%")
            ->orWhere('email', 'LIKE', "%$palavraPesquisa%")
            ->paginate(10);

        return view("painel.usuarios.index", compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->findOrFail($id)->delete();
        return 1;
    }


    public function missingMethod($parameters = array()) {
        return view('auth.login');
    }

}

