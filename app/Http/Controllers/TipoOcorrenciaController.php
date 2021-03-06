<?php

namespace App\Http\Controllers;

use App\Models\TipoOcorrencia;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Validation\Factory as Validate;

class TipoOcorrenciaController extends Controller
{

    private $request;
    private $validate;
    private $tipoOcorrencia;

    public function __construct(Request $request, TipoOcorrencia $tipoOcorrencia, Validate $validate)
    {
        $this->tipoOcorrencia = $tipoOcorrencia;
        $this->validate = $validate;
        $this->request = $request;
        $this->middleware('auth');
    }

    public function index()
    {
        $titulo = "Listagem de Tipo de Ocorrências";
        $tipoOcorrencias = $this->tipoOcorrencia->all();
        return view('painel.tipo-ocorrencias.index', compact('tipoOcorrencias', 'titulo'));
    }

    public function listaTipoOcorrencias()
    {
        return '{ "data": '. TipoOcorrencia::query()->select("nome")->get()->toJson().'}';
//        return Datatables::of(TipoOcorrencia::query()->select("tipo_ocorrencias.id", "tipo_ocorrencias.nome"))->make(true);
    }

    public function create()
    {
        $titulo = "Cadastrar Tipo de Ocorrência";
        return view('painel.tipo-ocorrencias.create-edit', compact('titulo'));
    }

    public function edit($id)
    {
        $titulo = "Editar Tipo de Ocorrência";
        if (!($tipoOcorrencia = TipoOcorrencia::find($id))) {
            throw new ModelNotFoundException("Tipo de Ocorrência não foi encontrado");
        }
        return view('painel.tipo-ocorrencias.create-edit', compact('tipoOcorrencia', 'titulo'));
    }

    public function delete($id)
    {
        TipoOcorrencia::findOrFail($id)->delete();
        return 1;
    }

    public function update($id)
    {
        $dadosForm = $this->request->all();

        $tipoOcorrencia = TipoOcorrencia::findOrFail($id);

//        dd($dadosForm);

        $validate = $this->validate->make($dadosForm, TipoOcorrencia::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

        $tipoOcorrencia->fill($dadosForm)->save();
        return 1;
    }

}
