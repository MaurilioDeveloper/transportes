<?php

namespace App\Http\Controllers;

use App\Frete;
use App\Caminhao;
use App\Motorista;
use Illuminate\Http\Request;
use App\Parceiro;
use App\Contato;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Request\ParceiroRequest;
use Datatables;
use Illuminate\Validation\Factory as Validate;

class FreteController extends Controller
{
    private $parceiro;
    private $request;
    private $caminhao;
    private $contato;
    private $motorista;
    private $validate;
    private $frete;

    public function __construct(Parceiro $parceiro, Request $request, Caminhao $caminhao, Contato $contato, Motorista $motorista, Validate $validate, Frete $frete)
    {
        $this->parceiro = $parceiro;
        $this->request = $request;
        $this->caminhao = $caminhao;
        $this->contato = $contato;
        $this->motorista = $motorista;
        $this->validate = $validate;
        $this->frete = $frete;
//        $this->middleware('auth');

    }

    public function index()
    {
        $fretes =  Frete::query()->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
        ->select("parceiros.nome", "fretes.id", "fretes.cidade_origem", "fretes.cidade_destino", "fretes.status", "fretes.tipo as tipo")->get();
//        dd($fretes);
        return view('painel.fretes.index', compact('fretes'));
    }

    public function create()
    {
//        $dadosForm = $this->request->all();
//        dd($dadosForm);
        $status = Frete::STATUS;
//        $data = '06/11/2016';
//        $data_hoje = implode('-',array_reverse(explode('/', $data)));
//        dd($data_hoje);

//        dd($status);
        $titulo = "Cadastrar Frete";
        return view('painel.fretes.create', compact('titulo', 'status'));
    }

    public function store()
    {
        $dadosForm = $this->request->all();
        $data_hoje = implode('-',array_reverse(explode('/', $dadosForm['data_hoje'])));
        $data_inicio = implode('-',array_reverse(explode('/', $dadosForm['data_inicio'])));
        $data_fim = implode('-',array_reverse(explode('/', $dadosForm['data_fim'])));
        $validate = $this->validate->make($dadosForm, Frete::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }


        $this->frete->create([
            'id_parceiro' => $dadosForm['id_parceiro'],
            'data_hoje' => $data_hoje,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'cidade_origem' => $dadosForm['cidade_origem'],
            'estado_origem' => $dadosForm['estado_origem'],
            'cidade_destino' => $dadosForm['cidade_destino'],
            'estado_destino' => $dadosForm['estado_destino'],
            'tipo' => $dadosForm['tipo'],
            'identificacao' => $dadosForm['identificacao'],
            'valor_item' => $dadosForm['valor_item'],
            'cor' => $dadosForm['cor'],
            'status' => $dadosForm['status'],
            'id_parceiro_coletor' => $dadosForm['id_parceiro_coletor'],
            'valor_coleta' => $dadosForm['valor_coleta'],
            'id_parceiro_entregador' => $dadosForm['id_parceiro_entregador'],
            'valor_entrega' => $dadosForm['valor_entrega'],
            'valor_total' => $dadosForm['valor_total'],
            'informacoes_complementares' => $dadosForm['informacoes_complementares'],

        ]);
        return 1;
    }

    public function edit($id)
    {
        if (!($frete = Frete::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }
        return view('painel.fretes.create', compact('frete'));
    }


    public function getFindParceiro($name)
    {
        $busca = Parceiro::where('nome','like','%'.$name.'%')->take(15)->get();
        return $busca;
    }

}
