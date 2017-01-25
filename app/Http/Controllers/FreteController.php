<?php

namespace App\Http\Controllers;

use App\Frete;
use App\Caminhao;
use App\FreteViagem;
use App\Motorista;
use App\OrigemDestino;
use App\HistoricoFrete;
use Illuminate\Http\Request;
use App\Parceiro;
use App\Contato;
use App\Viagem;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;
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
    private $frete;
    private $historico;
    private $validate;

    public function __construct(Parceiro $parceiro, Request $request, Caminhao $caminhao,
                                Contato $contato, Motorista $motorista, Validate $validate,
                                Frete $frete, HistoricoFrete $historico)
    {
        $this->parceiro = $parceiro;
        $this->request = $request;
        $this->caminhao = $caminhao;
        $this->contato = $contato;
        $this->motorista = $motorista;
        $this->frete = $frete;
        $this->historico = $historico;
        $this->validate = $validate;
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

        $parceiros = Parceiro::query()->select("parceiros.id", "parceiros.nome")->pluck('nome', 'id');
//        dd($parceiros);
//        $fretes =  Frete::query()
//            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//            ->join('origens_destinos', 'origens_destinos.id', '=', 'fretes.id_cidade_origem')
//        ->select("parceiros.nome", "fretes.id", "origens_destinos.cidade", "origens_destinos.cidade", "fretes.status", "fretes.tipo as tipo")->paginate(10);
//        dd($fretes);
        return view('painel.fretes.index', compact('parceiros'));
    }

    public function create($idParceiro=null)
    {
//        $status = Frete::STATUS;
        $nomeParceiro = '';

        if(isset($idParceiro)){
            $nomeParceiro = $this->parceiro->where('id', $idParceiro)->first();
//            $nomeParceiro = str_replace('["', '', str_replace('"]', '', $nomeParceiro));
//            dd($nomeParceiro);
            $nomeParceiro = $nomeParceiro['nome'];

//            return utf8_encode(str_replace('["', '', str_replace('"]', '', $nomeParceiro)));
        }

        $titulo = "Cadastrar Frete";
        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');


        return view('painel.fretes.create-edit', compact('titulo', 'cidades', 'idParceiro', 'nomeParceiro'));
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

//        return '{ "data": '.Frete::query()
//            ->join('parceiros as p', 'p.id', '=', 'fretes.id_parceiro')
//            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
//            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_destino')
//            ->select("p.nome", "fretes.id", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.status", "fretes.tipo")
//            ->get()->toJson(). '}';


        return Datatables::of(Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos AS od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos AS od2', 'od2.id', '=', 'fretes.id_cidade_destino')
            ->select("parceiros.nome", "fretes.id", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.identificacao", "fretes.chassi", "fretes.status", "fretes.tipo"))
            ->make(true);


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
        if(count(FreteViagem::where('id_frete', $id)->get()) > 0){
            return FreteViagem::where('id_frete', $id)->pluck('id_viagem');
        }
        Frete::findOrFail($id)->delete();
        FreteViagem::where('id_frete', $id)->delete();
        HistoricoFrete::where('id_frete',$id)->delete();
        return 1;
    }



    public function store()
    {
        $dadosForm = $this->request->all();
//        dd($dadosForm);
        $data_hoje = implode('-',array_reverse(explode('/', $dadosForm['data_hoje'])));
        $data_inicio = implode('-',array_reverse(explode('/', $dadosForm['data_inicio'])));
        $data_fim = implode('-',array_reverse(explode('/', $dadosForm['data_fim'])));
        $valor_item = str_replace('R$', '',$dadosForm['valor_item']);
        $valor_coleta = str_replace('R$', '',$dadosForm['valor_coleta']);
        $valor_entrega = str_replace('R$', '',$dadosForm['valor_entrega']);
        $valor_total = str_replace('R$', '',$dadosForm['valor_total']);
        $file = $this->request->file('image');
        if($this->request->hasFile('image')){
            $dadosForm['image'] = $file->getClientOriginalName();
//        dd($imageName);
            $file->move(public_path('fretes_imagens/'), $file->getClientOriginalName());
        }else{
            $dadosForm['image'] = NULL;
        }

//        dd($dadosForm['image']);
//        dd($dadosForm['valor_total2']);
//        dd($this->request->file('image'));



        $this->verificaColetaEntrega($dadosForm);



        $this->validationFrete($dadosForm);

        $user = $dadosForm['id_usuario'];
//        dd($user);





        $frete = $this->frete->create([
            'id_parceiro' => $dadosForm['id_parceiro'],
            'data_hoje' => $data_hoje,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'id_cidade_origem' => $dadosForm['id_cidade_origem'],
            'id_cidade_destino' => $dadosForm['id_cidade_destino'],
            'tipo' => $dadosForm['tipo'],
            'identificacao' => strtoupper($dadosForm['identificacao']),
            'valor_item' => $valor_item,
            'cor' => $dadosForm['cor'],
            'status' => $this->resolverStatus($dadosForm['status']),
            'iscoleta' => $iscoleta,
            'isentrega' => $isentrega,
            'id_parceiro_coletor' => $parceiro_coletor,
            'valor_coleta' => $valor_coleta,
            'id_parceiro_entregador' => $parceiro_entregador,
            'valor_entrega' => $valor_entrega,
            'valor_total' => $valor_total,
            'image' => $dadosForm['image'],
            'informacoes_complementares' => $dadosForm['informacoes_complementares'],

        ]);


        $historico = $this->historico->create([
            'data' => $data_hoje,
            'status' => $this->resolverStatus($dadosForm['status']),
            'id_usuario' => $user,
            'id_frete' => $frete->id
        ]);

//        dd($dadosForm['valor_coleta']);

//        return 1;
        return redirect()->route('listarFretes');
    }

    private function resolverStatus($s)
    {
        switch ($s)
        {
            case 1: return "Em Edição"; break;
            case 2: return "Aguardando Coleta"; break;
            case 3: return "Aguardando entrega no pátio";break;
            case 4: return "Aguardando Embarque";break;
            case 5: return "Em trânsito";break;
            case 6: return "Entregue";break;
            case 7: return "Cancelado";break;
        }
    }

    public function edit($id)
    {
        $titulo = 'Editar Frete';
        if (!($frete = Frete::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }
//        dd($frete);

        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');
//        $estados = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.estado")->pluck('estado', 'id');
        $data_hoje = implode('/',array_reverse(explode('-',$frete->data_hoje)));
        $data_inicio = implode('/',array_reverse(explode('-',$frete->data_inicio)));
        $data_fim = implode('/',array_reverse(explode('-',$frete->data_fim)));
        $freteParceiro = $this->parceiro->where('id', $frete->id_parceiro)->first();
        $freteParceiroColetor = $this->parceiro->where('id', $frete->id_parceiro_coletor)->first();
        $freteParceiroEntregador = $this->parceiro->where('id', $frete->id_parceiro_entregador)->first();
        $fretePessoaFJ = $this->parceiro->where('id', $frete->id_parceiro)->pluck('pessoa')->toJson();
        $sexoMF = $this->parceiro->where('id', $frete->id_parceiro)->pluck('sexo')->toJson();
//        dd($sexo);
        $fretePessoa = str_replace('["', '', str_replace('"]', '',$fretePessoaFJ));
        $sexo = str_replace('["', '', str_replace('"]', '',$sexoMF));
//        $freteParceiro =  Frete::query()->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//                    ->select("parceiros.nome")->where('id_parceiro', $frete->id_parceiro)->where('fretes.id', $id)->get('nome')->toJson();
//        dd($freteParceiro);
        $freteParceiroNome = $freteParceiro['nome'];
        $freteParceiroColetorNome = $freteParceiroColetor['nome'];
        $freteParceiroEntregadorNome = $freteParceiroEntregador['nome'];

//        dd(str_replace('["', '', str_replace('"]', '',$freteParceiro)));
        $iscoleta = $frete->iscoleta;
        $isentrega = $frete->isentrega;

//        $historicoFretes = HistoricoFrete::where('id_frete', $frete->id)->orderBy('data', 'ASC')->get();
        $historicoFretes = HistoricoFrete::query()->join('users', 'users.id', '=', 'historico_fretes.id_usuario')
                            ->select("historico_fretes.id", "historico_fretes.data", "historico_fretes.status", "users.name", "historico_fretes.created_at")
                            ->where("id_frete", $frete->id)->orderBy('created_at', 'DESC')->get();
//        dd($historicoFretes);


//        dd($frete);
        return view('painel.fretes.create-edit', compact('frete', 'titulo', 'data_hoje', 'data_inicio', 'data_fim', 'freteParceiroNome', 'iscoleta', 'isentrega',
                                                         'freteParceiroColetorNome', 'freteParceiroEntregadorNome', 'fretePessoa', 'sexo', 'cidades', 'historicoFretes'));
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

//        dd($frete->image);
        if(isset($dadosForm['image']) && $dadosForm['image'] != $frete->image){
            $file= $frete->image;
            $filename = public_path().'/fretes_imagens/'.$file;
            \File::delete($filename);
            $file = $this->request->file('image');
            $dadosForm['image'] = $file->getClientOriginalName();
            $file->move(public_path('fretes_imagens/'), $file->getClientOriginalName());
            //File::delete('fretes_imagens/'.$file->getClientOriginalName();

        }else{
            $dadosForm['image'] = $frete->image;
        }


        $this->verificaColetaEntrega($dadosForm);

//        $fretes =  Frete::query()->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//            ->select("parceiro.nome")->where('id_parceiro', $dadosForm['id_parceiro']);


        $this->validationFrete($dadosForm);

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
            'identificacao' => strtoupper($dadosForm['identificacao']),
            'valor_item' => $valor_item,
            'cor' => $dadosForm['cor'],
            'status' => $this->resolverStatus($dadosForm['status']),
            'iscoleta' => $iscoleta,
            'isentrega' => $isentrega,
            'id_parceiro_coletor' => $parceiro_coletor,
            'valor_coleta' => $valor_coleta,
            'id_parceiro_entregador' => $parceiro_entregador,
            'valor_entrega' => $valor_entrega,
            'valor_total' => $valor_total,
            'image' => $dadosForm['image'],
            'informacoes_complementares' => $dadosForm['informacoes_complementares'],
            'chassi' => $dadosForm['chassi']

        ])->save();

        $confirmHistorico = HistoricoFrete::where('id_frete', $frete->id)->orderBy('data', 'DESC')->get();

        $statusFrete = $this->resolverStatus($dadosForm['status']);

        if(count($confirmHistorico) == 0 || $confirmHistorico[0]['status'] != $statusFrete){
            $historico = $this->historico->create([
                'data' => date('Y/m/d'),
                'status' => $statusFrete,
                'id_usuario' => auth()->user()->id,
                'id_frete' => $frete->id
            ]);
        }
        return redirect()->route('listarFretes');

    }


    public function filtrar()
    {

        $dadosForm = $this->request->all();

        $status = $this->resolverStatus($dadosForm['status']);

//        $dadosPesquisa = Frete::query()
//            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
//            ->join('origens_destinos AS od', 'od.id', '=', 'fretes.id_cidade_origem')
//            ->join('origens_destinos AS od2', 'od2.id', '=', 'fretes.id_cidade_destino')
//            ->select("parceiros.nome", "fretes.id", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.identificacao", "fretes.chassi", "fretes.status", "fretes.tipo")
//            ->orWhere('fretes.identificacao', '<>', '')
//            ->orWhere('chassi', '<>', '')
//            ->where('status', 'LIKE', "%$status%")
//            ->paginate(10);

        return view("painel.fretes.index", compact('status'));
//
    }


    public function buscaPorStatus($status)
    {
        $dadosPesquisa = Frete::where('status','like','%'.$status.'%')->take(15)->get();

        return view('painel.fretes.index', compact('status'));
//        return $busca;
    }



    public function getFindParceiro($name)
    {
        $busca = Parceiro::where('nome','like','%'.$name.'%')->take(15)->get();
        return $busca;
    }

    protected function validationFrete($dadosForm)
    {

        $validate = $this->validate->make($dadosForm, Frete::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

    }

    private function verificaColetaEntrega()
    {
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
    }

}
