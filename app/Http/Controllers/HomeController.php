<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frete;

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

        $tableDash = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->select("parceiros.nome", "fretes.tipo", "fretes.data_inicio")
            ->where('status', 'Aguardando Coleta')
            ->orWhere('status', 'Em trânsito')
            ->orderBy('data_inicio', 'ASC')->get();
//        dd($tableDash);

        return view('home', compact('freteEdicao', 'freteAc', 'freteAe', 'freteEt', 'freteE', 'freteC', 'tableDash'));
    }
}
