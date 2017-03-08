<?php

namespace App\Http\Controllers;

use App\OrigemDestino;
use Illuminate\Http\Request;
use App\Parceiro;
use App\Frete;
use App\Viagem;
use App\Caminhao;
use App\FreteViagem;
use App\HistoricoViagem;
use DB;
use Datatables;
use Illuminate\Validation\Factory as Validate;
use Yajra\Datatables\Engines\QueryBuilderEngine;

class ViagemController extends Controller
{

    private $frete;
    private $request;
    private $viagem;
    private $parceiro;
    private $caminhao;
    private $freteViagem;
    private $historico;
    private $validate;

    public function __construct(Frete $frete, Request $request, Viagem $viagem,
                                Parceiro $parceiro, Caminhao $caminhao, FreteViagem $freteViagem,
                                HistoricoViagem $historico, Validate $validate)
    {
        $this->frete = $frete;
        $this->request = $request;
        $this->viagem = $viagem;
        $this->parceiro = $parceiro;
        $this->caminhao = $caminhao;
        $this->freteViagem = $freteViagem;
        $this->historico = $historico;
        $this->validate = $validate;
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view painel/fretes
     */
    public function index()
    {
        $titulo = "Listagem de Viagens";
        return view('painel.viagens.index', compact('titulo'));
    }

    /**
     * @param null $idParceiro
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view painel/fretes/create
     */
    public function create($idViagemParceiro=null)
    {

        $nomeViagemParceiro = '';

        if(isset($idViagemParceiro)){
            $nomeViagemParceiro = $this->parceiro->where('id', $idViagemParceiro)->first();
            $idParceiro = $nomeViagemParceiro['id'];
//            dd($nomeViagem);
            $nomeViagemParceiro = $nomeViagemParceiro['nome'];

            $dadosCaminhao =
                DB::select(
                     DB::raw("
                          select c.placa, c.modelo, c.id from parceiros p, caminhoes c
                          where c.id_parceiro = p.id
                          and c.id_parceiro = $idParceiro
                    ")
                );

            $dadosMotorista =
            DB::select(
                DB::raw("
                      select m.nome, m.id from parceiros p, motoristas m
                      where m.id_parceiro = p.id
                      and m.id_parceiro = $idParceiro
                    ")
            );
            


        }


        $fretes = DB::select(
            DB::raw("SELECT p.nome, f.tipo, IF(length(f.identificacao)>0,f.identificacao, f.chassi) as identificacao, od.cidade as cidade_origem, od2.cidade as cidade_destino, f.id
                    FROM fretes f
                    INNER JOIN parceiros p
                    ON f.id_parceiro = p.id
                    INNER JOIN origens_destinos od
                    ON f.id_cidade_origem = od.id
                    INNER JOIN origens_destinos od2
                    ON f.id_cidade_destino = od2.id
                    WHERE f.status = 'Aguardando Embarque'
                    AND NOT EXISTS (select 1 from fretes_viagens WHERE fretes_viagens.id_frete = f.id) 
                       ORDER BY p.nome")
        );
        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');
        $titulo = "Cadastrar Viagens";
        return view('painel.viagens.create-edit', compact('titulo', 'fretes', 'cidades', 'nomeViagemParceiro', 'idViagemParceiro', 'dadosCaminhao', 'dadosMotorista'));
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * Post for create a new Viagem
     */
    public function store()
    {
        $dadosForm = $this->request->except(['fretes', 'custos']);
        $dadosFormFretes = $this->request->only(['fretes']);
        $dadosFormCustos = $this->request->only(['custos']);
        $dadosForm['data_inicio'] = implode('-', array_reverse(explode('/', $dadosForm['data_inicio'])));
        $dadosForm['data_fim'] = implode('-', array_reverse(explode('/', $dadosForm['data_fim'])));
        $dadosForm['status'] = $this->resolverStatus($dadosForm['status']);

        $this->validationViagem($dadosForm);

        $viagem = $this->viagem->create($dadosForm);

        $data_hoje = date('Y/m/d');
        $status = $dadosForm['status'];
        $user = auth()->user()->id;

        $historico = $this->historico->create([
            'data' => $data_hoje,
            'status' => $status,
            'id_usuario' => $user,
            'id_viagem' => $viagem->id
        ]);

        $this->gravarFretesViagem($viagem->id, $dadosFormFretes, $dadosForm, $dadosFormCustos);

        return 1;

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * Return data for listing freight with Datatables
     */
    public function listaFretes()
    {
        /**
         * @var $dt QueryBuilderEngine
         */
        $dt = \Yajra\Datatables\Datatables::of(Viagem::query()
            ->join('parceiros', 'parceiros.id', '=', 'viagens.id_parceiro_viagem')
            ->join('origens_destinos as od', 'od.id', '=', 'viagens.id_cidade_origem')
            ->join('motoristas as m', 'm.id', '=', 'viagens.id_motorista')
            ->join('caminhoes as c', 'c.id', '=', 'viagens.id_caminhao')
            ->join('origens_destinos as od2', 'od2.id', '=', 'viagens.id_cidade_destino')
            ->leftJoin('fretes_viagens as fv','fv.id_viagem','=','viagens.id')
            ->leftJoin('fretes as f','f.id','=','fv.id_frete')
            ->groupBy('viagens.id')
            ->select("viagens.id", "parceiros.nome as parceiro", "m.nome as motorista", "c.modelo as caminhao", "viagens.status", "viagens.data_inicio", "od.cidade as cidade_origem", "od2.cidade as cidade_destino"));

        return $dt->make(true);

    }

    /**
     * @param $idFrete
     * @return int
     * Verify if exists freights presents in travel.
     */
    public function fretePresenteViagem($idFrete)
    {
        return count(FreteViagem::where('id_frete', $idFrete)->get());
    }


    /**
     * @param $name
     * @return array
     * Search Parceiro by name
     */
    public function buscaParceiro($name)
    {
        $busca = DB::select(
            DB::raw("
              select p.nome, p.id from parceiros p, caminhoes c, motoristas m
              where c.id_parceiro = p.id and m.id_parceiro = p.id
              and (select count(m1.id) from motoristas m1 where m1.id_parceiro = p.id) >= 1
              and (select count(c1.id) from caminhoes c1 where c1.id_parceiro = p.id) >= 1
              and p.nome LIKE '%$name%' group by p.id
            ")
        );
        return $busca;
    }

    /**
     * @param $id
     * @return array
     * Search Motorista by id
     */
    public function buscaMotorista($id)
    {
        $busca = DB::select(
            DB::raw("
              select m.nome, m.id from parceiros p, motoristas m
              where m.id_parceiro = p.id
              and m.id_parceiro = $id
            ")
        );
//        return view('painel.viagens.create-edit', compact('busca'));
        return $busca;
    }

    /**
     * @param $id
     * @return array
     * Search Caminhão by id
     */
    public function buscaCaminhao($id)
    {
        $busca = DB::select(
            DB::raw("
              select c.placa, c.modelo, c.id from parceiros p, caminhoes c
              where c.id_parceiro = p.id
              and c.id_parceiro = $id
            ")
        );
//        return view('painel.viagens.create-edit', compact('busca'));
        return $busca;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view for edit a travel.
     */
    public function edit($id)
    {
        $titulo = 'Editar Viagem';
        // Retorna todos os dados da Viagem conforme seu ID.
        $viagem = Viagem::findOrFail($id);
        $viagem['data_inicio'] = implode('/', array_reverse(explode('-', $viagem->data_inicio)));
        $viagem['data_fim'] = implode('/', array_reverse(explode('-', $viagem->data_fim)));
        $viagemNome = $this->parceiro->where('id', $viagem->id_parceiro_viagem)->first();
        $viagemNome = $viagemNome['nome'];

        $nomeCaminhao = Viagem::query()
            ->join('caminhoes', 'caminhoes.id', '=', 'viagens.id_caminhao')
            ->select("caminhoes.modelo", "caminhoes.placa")->where('id_caminhao', $viagem->id_caminhao)
            ->pluck('modelo', 'placa')->toJson();
        $nomeCaminhao = str_replace('{"', '', str_replace('"', '', str_replace('{', '', str_replace('}', '', implode(' - ', explode(':', $nomeCaminhao))))));

        $nomeMotorista = Viagem::query()
            ->join('motoristas', 'motoristas.id', '=', 'viagens.id_motorista')
            ->select("motoristas.nome")->where('id_motorista', $viagem->id_motorista)
            ->pluck('nome')->toJson();
        $nomeMotorista = str_replace('["', '', str_replace('"]', '', $nomeMotorista));
        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');
//        $estados = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.estado")->pluck('estado', 'id');

        $historicoViagens = HistoricoViagem::query()->join('users', 'users.id', '=', 'historico_viagens.id_usuario')
            ->select("historico_viagens.id", "historico_viagens.data", "historico_viagens.status", "users.name", "historico_viagens.created_at")
            ->where("id_viagem", $viagem->id)->orderBy('created_at', 'DESC')->get();


        $fretes = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_destino')
            ->select("parceiros.nome", "fretes.tipo", "fretes.identificacao", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.id")
            ->where('status', 'Aguardando Embarque')->get();
//        dd($fretes);

        $fretesAdicionados = Viagem::query()
            ->join('fretes_viagens', 'fretes_viagens.id_viagem', '=', 'viagens.id')
            ->join('fretes', 'fretes.id', '=', 'fretes_viagens.id_frete')
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_destino')
            ->select("parceiros.nome", "fretes_viagens.custos", "fretes.tipo", "fretes.identificacao",  "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.id")
            ->where('fretes_viagens.id_viagem', $viagem->id)
            ->get();

        //dd($fretesAdicionados);

        $fretesAdd = $this->freteViagem->all()->where('id_viagem', $viagem->id);

        return view('painel.viagens.create-edit', compact('titulo', 'viagem', 'fretes', 'viagemNome', 'nomeMotorista',
                                                           'nomeCaminhao', 'fretesAdicionado', 'cidades', 'fretesAdicionados',
                                                            'fretesAdd', 'historicoViagens'));


    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Verify freights add in a travel.
     */
    public function fretesAdicionados($id)
    {

        $fretesAdicionado = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_destino')
//            ->join('fretes_viagens as fo', 'fo.id_frete', '=', 'fretes.id')
            ->select("parceiros.nome", "fretes.tipo", "fretes.identificacao", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.id")
            ->where('fretes.id', $id)->get();
        return $fretesAdicionado;
    }

    /**
     * @param $s
     * @return string
     * Method for use in others methods, simplifying utility
     */
    private function resolverStatus($s)
    {
        switch ($s)
        {
            case 1: return "Aguardando Inicio"; break;
            case 2: return "Em Viagem"; break;
            case 3: return "Concluída";break;
            case 4: return "Cancelada";break;
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Filter travels by status
     */
    public function filtrar()
    {
        $dadosForm = $this->request->all();
        $status = $this->resolverStatus($dadosForm['status']);

        return view("painel.viagens.index", compact('status'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Return PUT for UPDATE a travel by ID
     */
    public function update($id)
    {
        $dadosForm = $this->request->except(['fretes', 'custos']);
        $dadosFormFretes = $this->request->only(['fretes']);
        $dadosFormCustos = $this->request->only(['custos']);

        $fretesViagemDB = FreteViagem::where('id_viagem', $id)->get()->keyBy('id');

        $viagem = Viagem::findOrFail($id);
        $dadosForm['data_inicio'] = implode('-',array_reverse(explode('/',$dadosForm['data_inicio'])));
        $dadosForm['data_fim'] = implode('-',array_reverse(explode('/',$dadosForm['data_fim'])));
        $dadosForm['status'] = $this->resolverStatus($dadosForm['status']);

        $this->validationViagem($dadosForm);

//        dd($dadosForm);
        $viagemObj = $viagem->fill($dadosForm)->save();

        // salvando fretes da viagem
        $this->gravarFretesViagem($viagem->id, $dadosFormFretes, $dadosForm, $dadosFormCustos);

        // historico de modificacao da status da viagem
        $confirmHistorico = HistoricoViagem::where('id_viagem', $viagem->id)->orderBy('data', 'DESC')->get();
        if(count($confirmHistorico)==0 || $confirmHistorico[0]['status'] != $dadosForm['status']){
            $historico = $this->historico->create([
                'data' => date('Y-m-d'),
                'status' => $dadosForm['status'],
                'id_usuario' => auth()->user()->id,
                'id_viagem' => $viagem->id
            ]);
        }
        return 1;
    }

    /**
     * @param $id_viagem
     * @param $dadosFormFretes
     * @param $dadosForm
     * @param $dadosFormCustos
     * Method used in others methods for save freights in a travel
     */
    protected function gravarFretesViagem($id_viagem, $dadosFormFretes, $dadosForm, $dadosFormCustos)
    {
        FreteViagem::where('id_viagem', $id_viagem)->delete();
        if (is_array($dadosFormFretes['fretes'])) {
            foreach ($dadosFormFretes['fretes'] as $codigo_frete) {
                // vendo se precisa modificar o status
                if ($dadosForm['status'] == 'Concluída') {
                    $frete = Frete::find($codigo_frete);
                    if($frete['id_cidade_destino'] == $dadosForm['id_cidade_destino']){
                        $frete->fill([
                            'status' => 'Entregue'
                        ])->save();
                    }else{
                        $frete->fill([
                            'status' => 'Aguardando Embarque'
                        ])->save();
                    }
                } elseif ($dadosForm['status'] == 'Em Viagem') {
                    $frete = Frete::find($codigo_frete);
                    $frete->fill([
                        'status' => 'Em trânsito'
                    ])->save();
                }

				$dadosFormCustosValue = str_replace('R$', '', str_replace(',', '',$dadosFormCustos["custos"][$codigo_frete]));

				
                FreteViagem::create([
                    'id_frete' => $codigo_frete,
                    'id_viagem' => $id_viagem,
                    'custos' => $dadosFormCustosValue
                ]);
            }
        }
    }

    /**
     * @param $id
     * @return int
     * Delete a travel by ID
     */
    public function deleteViagem($id)
    {
        Viagem::findOrFail($id)->delete();
        FreteViagem::where('id_viagem', $id)->delete();
        HistoricoViagem::where('id_viagem',$id)->delete();
        return 1;
    }


    /**
     * @param $dadosForm
     * @return string
     * Method used in others method for Validation a travel
     */
    protected function validationViagem($dadosForm)
    {
        $validate = $this->validate->make($dadosForm, Viagem::$rules);
        if ($validate->fails()) {
            $messages = $validate->messages();
            $displayErrors = '';

            foreach ($messages->all("<p>:message</p>") as $error) {
                $displayErrors .= $error;
            }

            return $displayErrors;
        }
    }

}
