<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViagemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('painel.viagens.index');
    }

    public function create()
    {
        $titulo = "Cadastrar Viagens";
        return view('painel.viagens.create-edit', compact('titulo'));
    }
}
