<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreteController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        return view('painel.fretes.index');
    }

    public function create()
    {
        return view('painel.fretes.gerenciar');
    }

    public function edit($id)
    {
        return view('painel.fretes.gerenciar')->with($id);
    }
}
