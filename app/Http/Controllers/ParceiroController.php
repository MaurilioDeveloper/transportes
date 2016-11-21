<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parceiro;

class ParceiroController extends Controller
{
    private $parceiro;
    private $request;

    public function __construct(Parceiro $parceiro, Request $request)
    {
        $this->middleware('auth');

        $this->parceiro = $parceiro;
        $this->request = $request;
    }

    public function index()
    {
        return view('painel.parceiros.index');
    }

    public function create()
    {
        $titulo = "Adicionar Parceiro";
        return view('painel.parceiros.gerenciar', compact('titulo'));
    }

    public function edit($id)
    {
        $titulo = "Editar Parceiro";
        $parceiro = $this->parceiro->find($id);

        return view('painel.parceiros.gerenciar', compact( 'parceiro', 'titulo' ));
    }
}
