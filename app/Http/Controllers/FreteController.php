<?php

namespace App\Http\Controllers;

use App\Frete;
use App\Caminhao;
use App\Motorista;
use App\OrigemDestino;
use Illuminate\Http\Request;
use App\Parceiro;
use App\Contato;
use App\Viagem;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Request\ParceiroRequest;
use Datatables;
use DB;
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
        $this->middleware('auth');

    }

    public function index()
    {

        $fretes = DB::select(
            DB::raw("SELECT p.nome, f.id, od.cidade, od2.cidade, f.status, f.tipo 
                     FROM `fretes` as f
                     INNER JOIN parceiros as p
                     ON p.id = f.id_parceiro
                     INNER JOIN origens_destinos as od
                     ON od.id = f.id_cidade_origem
                     INNER JOIN origens_destinos as od2
                     ON od2.id = f.id_cidade_destino"
            )
        );
//        $fretes =  Frete::query()
//            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//            ->join('origens_destinos', 'origens_destinos.id', '=', 'fretes.id_cidade_origem')
//        ->select("parceiros.nome", "fretes.id", "origens_destinos.cidade", "origens_destinos.cidade", "fretes.status", "fretes.tipo as tipo")->paginate(10);
//        dd($fretes);
        return view('painel.fretes.index');
    }

    public function create()
    {
//        $status = Frete::STATUS;
        $titulo = "Cadastrar Frete";
        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');
//        $estados = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.estado")->pluck('estado', 'id');

        return view('painel.fretes.create-edit', compact('titulo', 'cidades'));
    }

    public function listaFretes()
    {
//        $results = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = :somevariable"), array(
//            'somevariable' => $someVariable,
//        ));;
//        $fretes =  DB::select(
//            DB::raw("SELECT p.nome, f.id, od.cidade as cidade_origem, od2.cidade as cidade_destino, f.status, f.tipo
//                     FROM `fretes` as f
//                     INNER JOIN parceiros as p
//                     ON p.id = f.id_parceiro
//                     INNER JOIN origens_destinos as od
//                     ON od.id = f.id_cidade_origem
//                     INNER JOIN origens_destinos as od2
//                     ON od2.id = f.id_cidade_destino"
//            )
//        );
//        return $fretes;

        return '{ "data": '.Frete::query()
            ->join('parceiros as p', 'p.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_destino')
            ->select("p.nome", "fretes.id", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.status", "fretes.tipo")
            ->get()->toJson(). '}';


    }


    public function listaViagem()
    {
        return Datatables::of(Viagem::query()
            ->join('parceiros as p', 'p.id', '=', 'viagens.id_parceiro_viagem')
            ->join('origens_destinos as od', 'od.id', '=', 'viagens.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'viagens.id_cidade_destino')
            ->select("p.nome", "viagens.id", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "viagens.status", "viagens.tipo"))
            ->make(true);
    }


    public function deleteFrete($id)
    {
        Frete::findOrFail($id)->delete();
        return 1;
    }

    public function store()
    {
        $dadosForm = $this->request->all();
        $data_hoje = implode('-',array_reverse(explode('/', $dadosForm['data_hoje'])));
        $data_inicio = implode('-',array_reverse(explode('/', $dadosForm['data_inicio'])));
        $data_fim = implode('-',array_reverse(explode('/', $dadosForm['data_fim'])));
        $valor_item = str_replace('R$', '',$dadosForm['valor_item']);
        $valor_coleta = str_replace('R$', '',$dadosForm['valor_coleta']);
        $valor_entrega = str_replace('R$', '',$dadosForm['valor_entrega']);
        $valor_total = str_replace('R$', '',$dadosForm['valor_total']);

        if($dadosForm['status'] == 1){
            $status = "Em Edição";
        }
        if($dadosForm['status'] == 2){
            $status = "Aguardando Coleta";
        }
        if($dadosForm['status'] == 3){
            $status = "Aguardando Embarque";
        }
        if($dadosForm['status'] == 4){
            $status = "Em trânsito";
        }
        if($dadosForm['status'] == 5){
            $status = "Entregue";
        }
        if($dadosForm['status'] == 6){
            $status = "Cancelado";
        }

        if(isset($dadosForm['iscoleta']) && isset($dadosForm['id_parceiro_coletor'])){
            $iscoleta = $dadosForm['iscoleta'];
            $parceiro_coletor = $dadosForm['id_parceiro_coletor'];
        }else{
            $iscoleta = null;
            $parceiro_coletor = null;
        }

        if(isset($dadosForm['isentrega']) && isset($dadosForm['id_parceiro_entregador'])){
            $isentrega = $dadosForm['isentrega'];
            $parceiro_entregador = $dadosForm['id_parceiro_entregador'];
        }else{
            $isentrega = null;
            $parceiro_entregador = null;
        }

//        $fretes =  Frete::query()->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//            ->select("parceiro.nome")->where('id_parceiro', $dadosForm['id_parceiro']);


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
            'id_cidade_origem' => $dadosForm['id_cidade_origem'],
//            'id_estado_origem' => $dadosForm['id_estado_origem'],
            'id_cidade_destino' => $dadosForm['id_cidade_destino'],
//            'id_estado_destino' => $dadosForm['id_estado_destino'],
            'tipo' => $dadosForm['tipo'],
            'identificacao' => $dadosForm['identificacao'],
            'valor_item' => $valor_item,
            'cor' => $dadosForm['cor'],
            'status' => $status,
            'iscoleta' => $iscoleta,
            'isentrega' => $isentrega,
            'id_parceiro_coletor' => $parceiro_coletor,
            'valor_coleta' => $valor_coleta,
            'id_parceiro_entregador' => $parceiro_entregador,
            'valor_entrega' => $valor_entrega,
            'valor_total' => $valor_total,
            'informacoes_complementares' => $dadosForm['informacoes_complementares'],

        ]);

//        dd($dadosForm['valor_coleta']);

        return 1;
    }

    public function edit($id)
    {
        $titulo = 'Editar Frete';
        if (!($frete = Frete::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }

        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');
//        $estados = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.estado")->pluck('estado', 'id');
        $data_hoje = implode('/',array_reverse(explode('-',$frete->data_hoje)));
        $data_inicio = implode('/',array_reverse(explode('-',$frete->data_inicio)));
        $data_fim = implode('/',array_reverse(explode('-',$frete->data_fim)));
        $freteParceiro = $this->parceiro->where('id', $frete->id_parceiro)->pluck('nome')->toJson();
        $freteParceiroColetor = $this->parceiro->where('id', $frete->id_parceiro_coletor)->pluck('nome')->toJson();
        $freteParceiroEntregador = $this->parceiro->where('id', $frete->id_parceiro_entregador)->pluck('nome')->toJson();
        $fretePessoaFJ = $this->parceiro->where('id', $frete->id_parceiro)->pluck('pessoa')->toJson();
        $sexoMF = $this->parceiro->where('id', $frete->id_parceiro)->pluck('sexo')->toJson();
//        dd($sexo);
        $fretePessoa = str_replace('["', '', str_replace('"]', '',$fretePessoaFJ));
        $sexo = str_replace('["', '', str_replace('"]', '',$sexoMF));
//        $freteParceiro =  Frete::query()->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//                    ->select("parceiros.nome")->where('id_parceiro', $frete->id_parceiro)->where('fretes.id', $id)->get('nome')->toJson();
//        dd($freteParceiro);
        $freteParceiroNome = str_replace('["', '', str_replace('"]', '',$freteParceiro));
        $freteParceiroColetorNome = str_replace('["', '', str_replace('"]', '',$freteParceiroColetor));
        $freteParceiroEntregadorNome = str_replace('["', '', str_replace('"]', '',$freteParceiroEntregador));
//        dd(str_replace('["', '', str_replace('"]', '',$freteParceiro)));
        $iscoleta = $frete->iscoleta;
        $isentrega = $frete->isentrega;

//        dd($frete);
        return view('painel.fretes.create-edit', compact('frete', 'titulo', 'data_hoje', 'data_inicio', 'data_fim', 'freteParceiroNome', 'iscoleta', 'isentrega', 'freteParceiroColetorNome', 'freteParceiroEntregadorNome', 'fretePessoa', 'sexo', 'cidades'));
    }

    /**
     * @return Update
     */
    public function update($id)
    {
        $dadosForm = $this->request->all();
//        dd($dadosForm['id']);
        $frete = Frete::findOrFail($id);
//        dd($dadosForm);
        $data_hoje = implode('-',array_reverse(explode('/', $dadosForm['data_hoje'])));
        $data_inicio = implode('-',array_reverse(explode('/', $dadosForm['data_inicio'])));
        $data_fim = implode('-',array_reverse(explode('/', $dadosForm['data_fim'])));
        $valor_item = str_replace('R$', '',$dadosForm['valor_item']);
        $valor_coleta = str_replace('R$', '',$dadosForm['valor_coleta']);
        $valor_entrega = str_replace('R$', '',$dadosForm['valor_entrega']);
        $valor_total = str_replace('R$', '',$dadosForm['valor_total']);

        if($dadosForm['status'] == 1){
            $status = "Em Edição";
        }
        if($dadosForm['status'] == 2){
            $status = "Aguardando Coleta";
        }
        if($dadosForm['status'] == 3){
            $status = "Aguardando Embarque";
        }
        if($dadosForm['status'] == 4){
            $status = "Em trânsito";
        }
        if($dadosForm['status'] == 5){
            $status = "Entregue";
        }
        if($dadosForm['status'] == 6){
            $status = "Cancelado";
        }

        if(isset($dadosForm['iscoleta'])){
            $iscoleta = $dadosForm['iscoleta'];
            $parceiro_coletor = $dadosForm['id_parceiro_coletor'];
        }else{
            $iscoleta = "off";
            $parceiro_coletor = null;
        }

        if(isset($dadosForm['isentrega']) && isset($dadosForm['id_parceiro_entregador'])){
            $isentrega = $dadosForm['isentrega'];
            $parceiro_entregador = $dadosForm['id_parceiro_entregador'];
        }else{
            $isentrega = null;
            $parceiro_entregador = null;
        }

//        $fretes =  Frete::query()->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//            ->select("parceiro.nome")->where('id_parceiro', $dadosForm['id_parceiro']);


        $validate = $this->validate->make($dadosForm, Frete::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }


        $update = $frete->fill([
            'id_parceiro' => $dadosForm['id_parceiro'],
            'data_hoje' => $data_hoje,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'id_cidade_origem' => $dadosForm['id_cidade_origem'],
//            'estado_origem' => $dadosForm['estado_origem'],
            'id_cidade_destino' => $dadosForm['id_cidade_destino'],
//            'estado_destino' => $dadosForm['estado_destino'],
            'tipo' => $dadosForm['tipo'],
            'identificacao' => $dadosForm['identificacao'],
            'valor_item' => $valor_item,
            'cor' => $dadosForm['cor'],
            'status' => $status,
            'iscoleta' => $iscoleta,
            'isentrega' => $isentrega,
            'id_parceiro_coletor' => $parceiro_coletor,
            'valor_coleta' => $valor_coleta,
            'id_parceiro_entregador' => $parceiro_entregador,
            'valor_entrega' => $valor_entrega,
            'valor_total' => $valor_total,
            'informacoes_complementares' => $dadosForm['informacoes_complementares'],

        ])->save();
//        dd($dadosForm['valor_entrega']);
//        dd($update);
        return 1;
        return redirect()->route('listarFretes');

    }


    public function getFindParceiro($name)
    {
        $busca = Parceiro::where('nome','like','%'.$name.'%')->take(15)->get();
        return $busca;
    }

}
