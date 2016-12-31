<?php

namespace App\Http\Controllers;

use App\OrigemDestino;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validate;

class OrigemDestinoController extends Controller
{
    private $validate;

    private $origemDestino;

    public function __construct(Validate $validate, OrigemDestino $origemDestino, Request $request)
    {
        $this->validate = $validate;
        $this->origemDestino = $origemDestino;
        $this->request = $request;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('painel.origens_destinos.index');
    }

    public function listaCidadesEstados()
    {
        return Datatables::of(OrigemDestino::query()
            ->select("origens_destinos.id",
                "origens_destinos.cidade",
                "origens_destinos.estado"))
            ->make(true);
    }

    public function create()
    {
        $titulo = "Cadastrar CIDADES-ESTADOS";
        return view('painel.origens_destinos.create-edit', compact('titulo'));
    }

    public function store()
    {
        $dadosForm = $this->request->all();

        $validate = $this->validate->make($dadosForm, OrigemDestino::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

        $this->origemDestino->create($dadosForm);

        return 1;



    }

    public function edit($id)
    {
        $titulo = 'Editar Cidade-Estado';
        // Retorna todos os dados da Viagem conforme seu ID.
        $cidadesEstados = OrigemDestino::findOrFail($id);

        return view('painel.origens_destinos.create-edit', compact('titulo', 'cidadesEstados'));

    }

    public function update($id)
    {
        $dadosForm = $this->request->all();
//        dd($dadosForm['id']);
        $cidadesEstados = OrigemDestino::findOrFail($id);


        $validate = $this->validate->make($dadosForm, OrigemDestino::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

        $cidadesEstados->fill($dadosForm)->save();
        return 1;
    }
}
