<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Pagination\BootstrapThreePresenter;

class Frete extends Model
{
    protected $guarded = ['id'];

    const STATUS = [
        1 => 'Em Edição',
        2 => 'Aguardando Coleta',
        3 => 'Aguardando entrega no pátio',
        4 => 'Aguardando Embarque',
        5 => 'Em trânsito',
        6 => 'Entregue',
        7 => 'Cancelado'
    ];

    static $rules = [
        'id_parceiro' => 'required',
        'data_inicio' => 'required',
        'id_cidade_origem' => 'required',
//        'id_estado_origem' => 'required',
        'id_cidade_destino' => 'required',
//        'id_estado_destino' => 'required',
        'valor_item' => 'required',
        'status' => 'required',
//        'image' => 'image|mimes:jpeg,png,jpg|max:1024'

    ];

}
