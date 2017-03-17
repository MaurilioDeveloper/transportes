<?php

namespace App\Http\Controllers;

use App\Models\Frete;
use App\Models\Caminhao;
use App\Models\FreteViagem;
use App\Models\Motorista;
use App\Models\OrigemDestino;
use App\Models\HistoricoFrete;
use App\Models\Parceiro;
use App\Models\Contato;
use App\Models\Viagem;
//use App\Http\Controllers\StandardController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;
use App\Http\Request\ParceiroRequest;
use Datatables;
use Illuminate\Validation\Factory as Validate;

class FreteController extends Controller
{

//    use \App\Traits\Standard;

    private $parceiro;
    private $request;
    private $caminhao;
    private $contato;
    private $motorista;
    private $frete;
    private $historico;
    private $viagem;
    private $validate;

    public function __construct(Parceiro $parceiro, Request $request, Caminhao $caminhao,
                                Contato $contato, Motorista $motorista, Validate $validate,
                                Frete $frete, Viagem $viagem, HistoricoFrete $historico)
    {
        $this->parceiro = $parceiro;
        $this->request = $request;
        $this->caminhao = $caminhao;
        $this->contato = $contato;
        $this->motorista = $motorista;
        $this->frete = $frete;
        $this->historico = $historico;
        $this->viagem = $viagem;
        $this->validate = $validate;
        $this->middleware('auth');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view painel/fretes
     */
    public function index()
    {
        $titulo = "Listagem de Fretes";
        $parceiros = Parceiro::query()->select("parceiros.id", "parceiros.nome")->pluck('nome', 'id');
        $localizacao = OrigemDestino::query()->select("origens_destinos.cidade", "origens_destinos.id")->pluck('cidade', 'id');

        return view('painel.fretes.index', compact('parceiros', 'titulo', 'localizacao'));
    }

    /**
     * @param null $idParceiro
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view painel/fretes/create
     */
    public function create($idParceiro = null)
    {
        $nomeParceiro = '';

        if (isset($idParceiro)) {
            $nomeParceiro = $this->parceiro->where('id', $idParceiro)->first();
            $nomeParceiro = $nomeParceiro['nome'];
        }

        $titulo = "Cadastrar Frete";
        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');

        return view('painel.fretes.create-edit', compact('titulo', 'cidades', 'idParceiro', 'nomeParceiro'));
    }

    /**
     * @return mixed
     * Return data for listing Fretes with Datatables
     */
    public function listaFretes()
    {

        $cidade = $this->request->get('cidade');
        $localizacao = $this->request->get('localizacao');
//        dd($localizacao);

        $q = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos AS od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos AS od2', 'od2.id', '=', 'fretes.id_cidade_destino')
            ->join('origens_destinos AS od3', 'od3.id', '=', 'fretes.id_cidade_localizacao')
            ->select("parceiros.nome", "fretes.id", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.identificacao", "fretes.chassi", "fretes.status", "fretes.tipo", "od3.cidade as localizacao");
        if (!$this->request->get('filtrar')) {
            $q->where('status', '!=', 'Entregue');
        }
        if($this->request->get('localizacao')){
            $q->where('od3.cidade', $localizacao);
        }
        if($this->request->get('cidade')){
            $q->where('od3.cidade', $cidade);
        }
        $dt = Datatables::of($q);
        return $dt->make(true);
    }

    /**
     * @return mixed
     * Return data for listing Viagens with Datatables
     */
    public function listaViagem()
    {
        $dt = Datatables::of(Viagem::query()
            ->join('parceiros as p', 'p.id', '=', 'viagens.id_parceiro_viagem')
            ->join('origens_destinos as od', 'od.id', '=', 'viagens.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'viagens.id_cidade_destino')
            ->select("p.nome", "viagens.id", "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "viagens.status", "viagens.tipo"));

        return $dt->make(true);

    }


    /**
     * @param $id
     * @return int
     * Delete freight by ID
     */
    public function deleteFrete($id)
    {
        if (count(FreteViagem::where('id_frete', $id)->get()) > 0) {
            return FreteViagem::where('id_frete', $id)->pluck('id_viagem');
        }
        Frete::findOrFail($id)->delete();
        FreteViagem::where('id_frete', $id)->delete();
        HistoricoFrete::where('id_frete', $id)->delete();
        return 1;
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * Post for create a new freight
     */
    public function store()
    {
        $dadosForm = $this->request->except(['id_usuario']);
        $user = $this->request->only(['id_usuario']);
        $dadosForm['data_hoje'] = implode('-', array_reverse(explode('/', $dadosForm['data_hoje'])));
        $dadosForm['data_inicio'] = implode('-', array_reverse(explode('/', $dadosForm['data_inicio'])));
        $dadosForm['data_fim'] = implode('-', array_reverse(explode('/', $dadosForm['data_fim'])));
        $dadosForm['valor_item'] = str_replace('R$', '', $dadosForm['valor_item']);
        $dadosForm['valor_coleta'] = str_replace('R$', '', $dadosForm['valor_coleta']);
        $dadosForm['valor_entrega'] = str_replace('R$', '', $dadosForm['valor_entrega']);
        $dadosForm['valor_total'] = str_replace('R$', '', $dadosForm['valor_total']);
        $dadosForm['status'] = $this->resolverStatus($dadosForm['status']);
        $dadosForm['id_cidade_localizacao'] = $dadosForm['id_cidade_origem'];

        $file = $this->request->file('image');
        if ($this->request->hasFile('image')) {
            $dadosForm['image'] = $file->getClientOriginalName();
            $file->move(public_path('fretes_imagens/'), $file->getClientOriginalName());
        } else {
            $dadosForm['image'] = NULL;
        }


        if (isset($dadosForm['iscoleta']) && isset($dadosForm['id_parceiro_coletor'])) {
            $iscoleta = $dadosForm['iscoleta'];
            $parceiro_coletor = $dadosForm['id_parceiro_coletor'];
        } else {
            $dadosForm['iscoleta'] = null;
            $dadosForm['id_parceiro_coletor'] = null;
        }

        if (isset($dadosForm['isentrega']) && isset($dadosForm['id_parceiro_entregador'])) {
            $isentrega = $dadosForm['isentrega'];
            $parceiro_entregador = $dadosForm['id_parceiro_entregador'];
        } else {
            $dadosForm['isentrega'] = null;
            $dadosForm['id_parceiro_entregador'] = null;
        }


//        parent::validationData($dadosForm, Frete::$rules);

        $this->validationFrete($dadosForm);


        $frete = $this->frete->create($dadosForm);

        $historico = $this->historico->create([
            'data' => $dadosForm['data_hoje'],
            'status' => $dadosForm['status'],
            'id_usuario' => $user['id_usuario'],
            'id_frete' => $frete->id
        ]);

        return redirect()->route('listarFretes');
    }

    /**
     * @param $s
     * @return string
     * Method for use in others methods, simplifying utility
     */
    private function resolverStatus($s)
    {
        switch ($s) {
            case 1:
                return "Em Edição";
                break;
            case 2:
                return "Aguardando Coleta";
                break;
            case 3:
                return "Aguardando entrega no pátio";
                break;
            case 4:
                return "Aguardando Embarque";
                break;
            case 5:
                return "Em trânsito";
                break;
            case 6:
                return "Entregue";
                break;
            case 7:
                return "Cancelado";
                break;
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view Edit a freight
     */
    public function edit($id)
    {
        $titulo = 'Editar Frete';
        if (!($frete = Frete::find($id))) {
            throw new ModelNotFoundException("Frete não foi encontrado");
        }
        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');
        $data_hoje = implode('/', array_reverse(explode('-', $frete->data_hoje)));
        $data_inicio = implode('/', array_reverse(explode('-', $frete->data_inicio)));
        $data_fim = implode('/', array_reverse(explode('-', $frete->data_fim)));
        $freteParceiro = $this->parceiro->where('id', $frete->id_parceiro)->first();
        $freteParceiroColetor = $this->parceiro->where('id', $frete->id_parceiro_coletor)->first();
        $freteParceiroEntregador = $this->parceiro->where('id', $frete->id_parceiro_entregador)->first();
        $fretePessoaFJ = $this->parceiro->where('id', $frete->id_parceiro)->pluck('pessoa')->toJson();
        $sexoMF = $this->parceiro->where('id', $frete->id_parceiro)->pluck('sexo')->toJson();

        $viagensFrete = Viagem::query()->join('parceiros as p', 'p.id', '=', 'viagens.id_parceiro_viagem')
            ->join('caminhoes as c', 'c.id', '=', 'viagens.id_caminhao')
            ->join('motoristas as m', 'm.id', '=', 'viagens.id_motorista')
            ->join('origens_destinos as oc', 'oc.id', '=', 'viagens.id_cidade_origem')
            ->join('origens_destinos as oc2', 'oc2.id', '=', 'viagens.id_cidade_destino')
            ->join('motoristas', 'motoristas.id', '=', 'viagens.id_motorista')
            ->join('fretes_viagens', 'fretes_viagens.id_viagem', '=', 'viagens.id')
            ->select("viagens.data_inicio", "viagens.status", "p.nome as parceiro", "c.placa", "c.modelo", "m.nome as motorista", "oc.cidade as cidade_origem", "oc2.cidade as cidade_destino", "fretes_viagens.custos")
            ->where("fretes_viagens.id_frete", $frete->id)
            ->orderBy("viagens.data_inicio", "ASC")
            ->get();
//        dd($viagensFrete);
//        dd($sexo);
        $fretePessoa = str_replace('["', '', str_replace('"]', '', $fretePessoaFJ));
        $sexo = str_replace('["', '', str_replace('"]', '', $sexoMF));
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

        return view('painel.fretes.create-edit', compact('frete', 'titulo', 'data_hoje', 'data_inicio', 'data_fim', 'freteParceiroNome', 'iscoleta', 'isentrega',
            'freteParceiroColetorNome', 'freteParceiroEntregadorNome', 'fretePessoa', 'sexo', 'cidades', 'historicoFretes', 'viagensFrete'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Return PUT for UPDATE a freight by ID
     */
    public function update($id)
    {
        $dadosForm = $this->request->except(['id_usuario']);
        $user = $this->request->only(['id_usuario']);
        $dadosForm['data_hoje'] = implode('-', array_reverse(explode('/', $dadosForm['data_hoje'])));
        $dadosForm['data_inicio'] = implode('-', array_reverse(explode('/', $dadosForm['data_inicio'])));
        $dadosForm['data_fim'] = implode('-', array_reverse(explode('/', $dadosForm['data_fim'])));
        $dadosForm['valor_item'] = str_replace('R$', '', $dadosForm['valor_item']);
        $dadosForm['valor_coleta'] = str_replace('R$', '', $dadosForm['valor_coleta']);
        $dadosForm['valor_entrega'] = str_replace('R$', '', $dadosForm['valor_entrega']);
        $dadosForm['valor_total'] = str_replace('R$', '', $dadosForm['valor_total']);
        $dadosForm['status'] = $this->resolverStatus($dadosForm['status']);
//        dd($dadosForm['id']);
        $frete = Frete::findOrFail($id);

//        dd($frete->image);
        if (isset($dadosForm['image']) && $dadosForm['image'] != $frete->image) {
            $file = $frete->image;
            $filename = public_path() . '/fretes_imagens/' . $file;
            \File::delete($filename);
            $file = $this->request->file('image');
            $dadosForm['image'] = $file->getClientOriginalName();
            $file->move(public_path('fretes_imagens/'), $file->getClientOriginalName());
            //File::delete('fretes_imagens/'.$file->getClientOriginalName();

        } else {
            $dadosForm['image'] = $frete->image;
        }


        if (isset($dadosForm['iscoleta']) && isset($dadosForm['id_parceiro_coletor'])) {
            $iscoleta = $dadosForm['iscoleta'];
            $parceiro_coletor = $dadosForm['id_parceiro_coletor'];
        } else {
            $dadosForm['iscoleta'] = null;
            $dadosForm['id_parceiro_coletor'] = null;
        }

        if (isset($dadosForm['isentrega']) && isset($dadosForm['id_parceiro_entregador'])) {
            $isentrega = $dadosForm['isentrega'];
            $parceiro_entregador = $dadosForm['id_parceiro_entregador'];
        } else {
            $dadosForm['isentrega'] = null;
            $dadosForm['id_parceiro_entregador'] = null;
        }


//        parent::validationData($dadosForm, Frete::$rules);
        $this->validationFrete($dadosForm);

        $update = $frete->fill($dadosForm)->save();

        $confirmHistorico = HistoricoFrete::where('id_frete', $frete->id)->orderBy('data', 'DESC')->get();;

        if (count($confirmHistorico) == 0 || $confirmHistorico[0]['status'] != $dadosForm['status']) {
            $historico = $this->historico->create([
                'data' => date('Y/m/d'),
                'status' => $dadosForm['status'],
                'id_usuario' => auth()->user()->id,
                'id_frete' => $frete->id
            ]);
        }
        return redirect()->route('listarFretes');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Method for filter results by status
     */
    public function filtrar()
    {
        $dadosForm = $this->request->all();
        $status = $this->resolverStatus($dadosForm['status']);
        $localizacao = OrigemDestino::query()->select("origens_destinos.cidade", "origens_destinos.id")->pluck('cidade', 'id');

        return view("painel.fretes.index", compact('status', 'localizacao'));
    }

    /**
     * @param $status
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Method for search freight by status
     */
    public function buscaPorStatus($status)
    {
        $dadosPesquisa = Frete::where('status', 'like', '%' . $status . '%')->take(15)->get();
        $localizacao = OrigemDestino::query()->select("origens_destinos.cidade", "origens_destinos.id")->pluck('cidade', 'id');
        return view('painel.fretes.index', compact('status', 'localizacao'));
    }


    /**
     * @param $name
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     * Method for search a Parceiro by name
     */
    public function getFindParceiro($name)
    {
        $busca = Parceiro::where('nome', 'like', '%' . $name . '%')->take(15)->get();
        return $busca;
    }

    /**
     * @param $dadosForm
     * @return string
     * Method of Validation used in others methods, simplifying utility
     */
//    validationData($dadosForm, Viagem);


    protected function validationFrete($dadosForm)
    {

        $validate = $this->validate->make($dadosForm, Frete::$rules);
        if ($validate->fails()) {
            $messages = $validate->messages();
            $displayErrors = '';

            foreach ($messages->all("<p>:message</p>") as $error) {
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

    }

    protected function buscaPorLocalizacao($cidade)
    {
        $dadosPesquisa = Frete::query()
            ->join('origens_destinos AS od', 'od.id', '=', 'fretes.id_cidade_localizacao')
            ->select("od.cidade as cidade_localizacao")
            ->where('od.cidade', $cidade)
            ->get();
        return view('painel.fretes.index', compact('cidade'));
    }


    protected function filtrarFreteLocalizacao()
    {
        $id = $this->request->get('localizacao');
        $filtroLocalizacao = OrigemDestino::query()->select("origens_destinos.cidade as localizacao")->where('origens_destinos.id', $id)->first();
        $filtroLocalizacao = $filtroLocalizacao->localizacao;
        $localizacao = OrigemDestino::query()->select("origens_destinos.cidade", "origens_destinos.id")->pluck('cidade', 'id');
        $pesquisa = Frete::query()
            ->join('origens_destinos AS od', 'od.id', '=', 'fretes.id_cidade_localizacao')
            ->select("od.cidade as cidade_localizacao")
            ->where('od.cidade', $filtroLocalizacao)
            ->get();
        return view('painel.fretes.index', compact('filtroLocalizacao','localizacao'));
    }

}
