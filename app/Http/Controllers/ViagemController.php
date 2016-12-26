<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parceiro;
use App\Frete;
use App\Viagem;
use DB;
use Datatables;

class ViagemController extends Controller
{

    private $frete;


    public function __construct(Frete $frete)
    {
        $this->frete = $frete;
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
            ->select("parceiros.nome", "fretes.tipo", "fretes.identificacao", "fretes.cidade_origem", "fretes.cidade_destino")
            ->where('status', 'Aguardando Embarque')->get();

        $titulo = "Cadastrar Viagens";
        return view('painel.viagens.create-edit', compact('titulo', 'fretes'));
    }

    public function store()
    {
        return "olá";
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
              select * from parceiros p, caminhoes c, motoristas m
              where c.id_parceiro = p.id and m.id_parceiro = p.id
              and (select count(m1.id) from motoristas m1 where m1.id_parceiro = p.id) >= 1
              and (select count(c1.id) from caminhoes c1 where c1.id_parceiro = p.id) >= 1
              and p.nome LIKE '%$name%'
            ")
        );
        return $busca;
    }

    public function buscaCaminhao($name, $idParceiro)
    {
        $busca = DB::select(
            DB::raw("
              select * from parceiros p, caminhoes c
              where c.id_parceiro = p.id and m.id_parceiro = p.id
              and p.nome LIKE '%$name%'
              and c.id = $idParceiro
            ")
        );
        return $busca;
    }
}
