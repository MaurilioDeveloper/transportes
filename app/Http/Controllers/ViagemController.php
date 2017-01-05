<?php

namespace App\Http\Controllers;

use App\OrigemDestino;
use Illuminate\Http\Request;
use App\Parceiro;
use App\Frete;
use App\Viagem;
use App\Caminhao;
use App\FreteViagem;
use DB;
use Datatables;
use Illuminate\Validation\Factory as Validate;

class ViagemController extends Controller
{

    private $frete;
    private $request;
    private $viagem;
    private $parceiro;
    private $caminhao;
    private $freteViagem;
    private $validate;

    public function __construct(Frete $frete, Request $request, Viagem $viagem, Parceiro $parceiro, Caminhao $caminhao, FreteViagem $freteViagem, Validate $validate)
    {
        $this->frete = $frete;
        $this->request = $request;
        $this->viagem = $viagem;
        $this->parceiro = $parceiro;
        $this->caminhao = $caminhao;
        $this->freteViagem = $freteViagem;
        $this->validate = $validate;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('painel.viagens.index');
    }

    public function create()
    {
        $fretes = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_destino')
            ->select("parceiros.nome", "fretes.tipo", "fretes.identificacao", "od.cidade as cidade_origem", "od.cidade as cidade_destino", "fretes.id")
            ->where('status', 'Aguardando Embarque')->get();
        $cidades = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.cidade")->orderBy('origens_destinos.cidade', 'ASC')->pluck('cidade', 'id');
//        $estados = OrigemDestino::query()->select("origens_destinos.id", "origens_destinos.estado")->pluck('estado', 'id');

//        dd($estados);

        $titulo = "Cadastrar Viagens";
        return view('painel.viagens.create-edit', compact('titulo', 'fretes', 'cidades'));
    }

    public function store()
    {
        $dadosForm = $this->request->except(['fretes']);
        $dadosFormFretes = $this->request->only(['fretes']);
//        dd($dadosFormFretes);
        $dadosForm['data_inicio'] = implode('-', array_reverse(explode('/', $dadosForm['data_inicio'])));
        $dadosForm['data_fim'] = implode('-', array_reverse(explode('/', $dadosForm['data_fim'])));
//        dd($dadosForm['id_caminhao']);

        if ($dadosForm['status'] == 1) {
            $dadosForm['status'] = "Aguardando Inicio";
        }
        if ($dadosForm['status'] == 2) {
            $dadosForm['status'] = "Em Viagem";
        }
        if ($dadosForm['status'] == 3) {
            $dadosForm['status'] = "Concluída";
        }
        if ($dadosForm['status'] == 4) {
            $dadosForm['status'] = "Cancelada";
        }


        $validate = $this->validate->make($dadosForm, Viagem::$rules);
        if ($validate->fails()) {
            $messages = $validate->messages();
            $displayErrors = '';

            foreach ($messages->all("<p>:message</p>") as $error) {
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

        $viagem = $this->viagem->create($dadosForm);

        foreach ($dadosFormFretes as $key => $value) {
//            dd($key);
            if(count($value) > 0){

                $fretesAdicionado = array_keys($value);
    //            dd($fretesAdicionado);
                $count = count($fretesAdicionado);
                for ($i = 0; $i < $count; $i++) {
                    $fretesAd = FreteViagem::create([
                        'id_frete' => $fretesAdicionado[$i],
                        'id_viagem' => $viagem->id
                    ]);
                }

            }
        }

//        if($viagem && $fretesAd){
        return 1;
//        }

    }

    public function listaFretes()
    {
        return Datatables::of(Viagem::query()
            ->join('parceiros', 'parceiros.id', '=', 'viagens.id_parceiro_viagem')
            ->join('origens_destinos as od', 'od.id', '=', 'viagens.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'viagens.id_cidade_destino')
            ->select("viagens.id", "parceiros.nome", "viagens.status", "viagens.horario_inicio", "od.cidade as cidade_origem", "od2.cidade as cidade_destino"))
            ->make(true);

//        return $this->frete->get()->where('status', 'Aguardando Embarque');
    }


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

    public function edit($id)
    {
        $titulo = 'Editar Viagem';
        // Retorna todos os dados da Viagem conforme seu ID.
        $viagem = Viagem::findOrFail($id);
        $viagem['data_inicio'] = implode('/', array_reverse(explode('-', $viagem->data_inicio)));
        $viagem['data_fim'] = implode('/', array_reverse(explode('-', $viagem->data_fim)));
        $viagemNome = $this->parceiro->where('id', $viagem->id_parceiro_viagem)->pluck('nome')->toJson();
        $viagemNome = str_replace('["', '', str_replace('"]', '', $viagemNome));
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

//        dd($nomeCaminhao);
//        dd($viagemNome);
//        dd($viagem);
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
            ->select("parceiros.nome", "fretes.tipo", "fretes.identificacao",  "od.cidade as cidade_origem", "od2.cidade as cidade_destino", "fretes.id")
            ->where('fretes_viagens.id_viagem', $viagem->id)
            ->get();
        //dd($fretesAdicionados);

        $fretesAdd = $this->freteViagem->all()->where('id_viagem', $viagem->id);

        return view('painel.viagens.create-edit', compact('titulo', 'viagem', 'fretes', 'viagemNome', 'nomeMotorista', 'nomeCaminhao', 'fretesAdicionado', 'cidades', 'fretesAdicionados', 'fretesAdd'));


    }

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


    public function update($id)
    {
        $dadosForm = $this->request->except(['fretes']);
        $dadosFormFretes = $this->request->only(['fretes']);
//        dd($dadosFormFretes);
        $fretesViagemDB = FreteViagem::where('id_viagem', $id)->get()->keyBy('id');
//        dd($fretesViagemDB);
        $viagem = Viagem::findOrFail($id);
//        dd(implode('-',array_reverse(explode('/',$dadosForm['data_fim']))));
        $dadosForm['data_inicio'] = implode('-',array_reverse(explode('/',$dadosForm['data_inicio'])));
        $dadosForm['data_fim'] = implode('-',array_reverse(explode('/',$dadosForm['data_fim'])));

//        dd($dadosForm['data_fim']);

        if ($dadosForm['status'] == 1) {
            $dadosForm['status'] = "Aguardando Inicio";
        }
        if ($dadosForm['status'] == 2) {
            $dadosForm['status'] = "Em Viagem";
        }
        if ($dadosForm['status'] == 3) {
            $dadosForm['status'] = "Concluída";
        }
        if ($dadosForm['status'] == 4) {
            $dadosForm['status'] = "Cancelada";
        }

        $validate = $this->validate->make($dadosForm, Viagem::$rules);
        if ($validate->fails()) {
            $messages = $validate->messages();
            $displayErrors = '';

            foreach ($messages->all("<p>:message</p>") as $error) {
                $displayErrors .= $error;
            }

            return $displayErrors;
        }
//        dd($viagem);

        $viagemObj = $viagem->fill($dadosForm)->save();


        if (is_array($dadosFormFretes)) {
//            dd($dadosFormFretes);
            foreach ($dadosFormFretes as $key => $value) {

                if($value == null){
                    $fretesAdicionado = null;
                    FreteViagem::where('id_viagem', $id)->delete();
                }else {
                    $fretesAdicionado = array_keys($value);
                }


//                dd($dadosFormFretes);
                if(count($value) > 0){
                {
                    $chave = array_keys($fretesViagemDB->toArray());
                    $countFrete = count($chave);
                }
                if (isset($chave) && count($fretesViagemDB) > 0) {
                    for ($i = 0; $i < $countFrete; $i++) {
                        if (!($viagemFrete = FreteViagem::find($chave[$i]))) {
                            throw new ModelNotFoundException("Fretes Viagem não foi encontrado");
                        } else {
                            $viagemFrete->delete($chave);

                            if($value != null){
                                $viagemFrete->create([
                                    'id_frete' => $fretesAdicionado[$i],
                                    'id_viagem' => $viagem->id
                                ]);
                            }
                        }


                        $i++;
                    }
                } else {
                    $count = count($fretesAdicionado);
                    for ($i = 0; $i < $count; $i++) {
                        $fretesAd = FreteViagem::create([
                            'id_frete' => $fretesAdicionado[$i],
                            'id_viagem' => $viagem->id
                        ]);
                    }
                }

            }

//            for($i = 0; $i < $count; $i++){
//                $fretesAd = $this->freteViagem->fill([
//                    'id_frete' => $fretesAdicionado[$i],
//                    'id_viagem' => $viagem->id
//                ]);

//            }
            }
        }

//        foreach ($fretesViagemDB as $viagemFrete) {
//            if (!$viagemFrete['presente']) {
//                FreteViagem::find($viagemFrete['id'])->delete();
//            }
//        }


//        $fretesAd->save();
        return 1;
//        dd($dadosForm);
    }


    public function deleteViagem($id)
    {
        Viagem::findOrFail($id)->delete();
        FreteViagem::where('id_viagem', $id)->delete();
        return 1;
    }



}
