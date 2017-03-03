<?php

namespace App\Http\Controllers;

use App\Role;
use App\RoleUser;
use Illuminate\Http\Request;
use App\Frete;
use App\Viagem;
use App\User;

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
            ->orderBy('data_inicio', 'ASC')->paginate(8);
//        dd($tableDash);


        $fretesOp = Frete::query()
            ->join('parceiros', 'parceiros.id', '=', 'fretes.id_parceiro')
            ->join('origens_destinos as od', 'od.id', '=', 'fretes.id_cidade_origem')
            ->join('origens_destinos as od2', 'od2.id', '=', 'fretes.id_cidade_origem')
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

        $user_role = RoleUser::query()
            ->join('users', 'users.id', '=', 'role_user.user_id')
            ->join('roles as r', 'r.id', '=', 'role_user.role_id')
            ->select("r.display_name")
            ->where('users.id', auth()->user()->id)
            ->get();
        $user_role = $user_role[0]->display_name;
//        $admin = Role::where('id', 1)->first();
//        $user = User::where('id', auth()->user()->id)->first();
//        $user->attachRole($admin); // parameter can be an Role object, array, or id
//        dd($user);

        // or eloquent's original technique
//        $user->roles()->attach($admin->id); // id only
//        dd(RoleUser::all()->toJson());


        return view('home', compact('freteEdicao', 'freteAc', 'freteAe', 'freteEt', 'freteE', 'freteC', 'tableDash', 'fretesOp', 'viagensOp', 'user_role'));
    }
}
