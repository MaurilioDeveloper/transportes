<?php

namespace App\Http\Controllers;

use App\Models\Frete;
use App\Models\Viagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    private $request;

    private $frete;

    public function __construct(Request $request, Frete $frete)
    {
        $this->frete = $frete;
        $this->request = $request;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freteEdicao = count($this->frete->all()->where('status', 'Em Edição'));
        $freteAc = count($this->frete->all()->where('status', 'Aguardando Coleta'));
        $freteAe = count($this->frete->all()->where('status', 'Aguardando Embarque'));
        $freteEt = count($this->frete->all()->where('status', 'Em trânsito'));
        $freteE = count($this->frete->all()->where('status', 'Entregue'));
        $freteC = count($this->frete->all()->where('status', 'Cancelado'));

        /*
        $graficoLocalizacao = DB::select(
            DB::raw("
              SELECT origens_destinos.cidade, count(*) as qtde from fretes 
              INNER JOIN origens_destinos 
              ON fretes.id_cidade_localizacao = origens_destinos.id 
              WHERE status LIKE '%Aguard%' 
              GROUP BY id_cidade_localizacao order by qtde desc
            ")
        );
        */




        $tableDash = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->select("parceiros.nome", "fretes.tipo", "fretes.data_inicio")
            ->where('status', 'Aguardando Coleta')
            ->orWhere('status', 'Em trânsito')
            ->orderBy('data_inicio', 'ASC')->paginate(8);
//        dd($tableDash);


        $fretesOp = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_destino')
            ->select("fretes.id", "parceiros.nome", "fretes.tipo", "fretes.identificacao", "fretes.status", "fretes.data_inicio", "od.cidade as cidade_origem", "od2.cidade as cidade_destino")
            ->where('status', '!=', 'Entregue')
            ->where('fretes.status', '!=', 'Cancelado')->paginate(5);
//        return $fretesOp;

        $viagensOp = Viagem::query()
            ->leftJoin('fretes_viagens','fretes_viagens.id_viagem','=','viagens.id')
            ->join('parceiros', 'parceiros.id', '=', 'viagens.id_parceiro_viagem')
            ->join('origens_destinos as od', 'od.id', '=', 'viagens.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'viagens.id_cidade_origem')
            ->select("viagens.id", "parceiros.nome", "viagens.status", "viagens.data_inicio", "od.cidade as cidade_origem", "od2.cidade as cidade_destino")
            ->selectRaw('count(fretes_viagens.id) as fretes_viagens')
            ->where('status', '<>', 'Concluída')
            ->where('status', '<>', 'Cancelada')
            ->groupBy('viagens.id')
            ->paginate(5);

        return view('home', compact('freteEdicao', 'freteAc', 'freteAe', 'freteEt', 'freteE', 'freteC', 'tableDash', 'fretesOp', 'viagensOp'));
    }

    public function listaLocalizacoes()
    {
        $graficoLocalizacao=Frete::query()
            ->join('origens_destinos', 'origens_destinos.id', '=', 'fretes.id_cidade_localizacao')
            ->select("origens_destinos.cidade as name")
            ->selectRaw('count(*) as y')
            ->where('status', 'like', '%Aguardando Embarque%')
            ->groupBy('id_cidade_localizacao')
            ->orderBy('y', 'DESC')
            ->get();
        return $graficoLocalizacao;
    }
}
