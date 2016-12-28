<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoOcorrencia;
use Datatables;

class TipoOcorrenciaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('painel.tipo-ocorrencias.index');
    }

    public function listaTipoOcorrencias()
    {
        return '{ "data": '. TipoOcorrencia::query()->select("nome")->get()->toJson().'}';
//        return Datatables::of(TipoOcorrencia::query()->select("nome"))->make(true);
    }

    public function create()
    {
        return view('painel.tipo-ocorrencias.create-edit');
    }

    public function edit($id)
    {
        if (!($tipoOcorrencia = TipoOcorrencia::find($id))) {
            throw new ModelNotFoundException("Tipo de Ocorrência não foi encontrado");
        }
        return view('painel.tipo-ocorrencias.create-edit', compact('tipoOcorrencia'));
    }
}
