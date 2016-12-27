<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parceiro;
use App\Frete;
use App\Viagem;
use DB;
use Datatables;
use Illuminate\Validation\Factory as Validate;

class ViagemController extends Controller
{

    private $frete;
    private $request;
    private $viagem;
    private $validate;

    public function __construct(Frete $frete, Request $request, Viagem $viagem, Validate $validate)
    {
        $this->frete = $frete;
        $this->request = $request;
        $this->viagem = $viagem;
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
            ->select("parceiros.nome", "fretes.tipo", "fretes.identificacao", "fretes.cidade_origem", "fretes.cidade_destino", "fretes.id")
            ->where('status', 'Aguardando Embarque')->get();

        $titulo = "Cadastrar Viagens";
        return view('painel.viagens.create-edit', compact('titulo', 'fretes'));
    }

    public function store()
    {
        $dadosForm = $this->request->all();
        $dadosForm['data_inicio'] = implode('-',array_reverse(explode('/', $dadosForm['data_inicio'])));
        $dadosForm['data_fim'] = implode('-',array_reverse(explode('/', $dadosForm['data_fim'])));

        if($dadosForm['status'] == 1){
            $dadosForm['status'] = "Aguardando Inicio";
        }
        if($dadosForm['status'] == 2){
            $dadosForm['status'] = "Em Viagem";
        }
        if($dadosForm['status'] == 3){
            $dadosForm['status'] = "Concluída";
        }
        if($dadosForm['status'] == 4){
            $dadosForm['status'] = "Cancelada";
        }

        $validate = $this->validate->make($dadosForm, Viagem::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }
//        dd($dadosForm);

        $this->viagem->create($dadosForm);

        return 1;

    }

    public function listaFretes()
    {
        return  Datatables::of(Viagem::query()
            ->join('parceiros', 'parceiros.id', '=', 'viagens.id_parceiro_viagem')
            ->join('fretes', 'fretes.id', '=', 'viagens.id_frete')
            ->select("parceiros.nome", "fretes.tipo", "fretes.identificacao", "viagens.cidade_origem", "viagens.cidade_destino"))
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
              and p.nome LIKE '%$name%' group by id
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
}
