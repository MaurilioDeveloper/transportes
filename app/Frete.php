<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frete extends Model
{
    protected $guarded = ['id'];

    const STATUS = [
        1 => 'Em Edição',
        2 => 'Aguardando Coleta',
        3 => 'Aguardando Embarque',
        4 => 'Em trânsito',
        5 => 'Entregue',
        6 => 'Cancelado'
    ];

    static $rules = [
        'id_parceiro' => 'required',
        'data_inicio' => 'required',
        'id_cidade_origem' => 'required',
//        'id_estado_origem' => 'required',
        'id_cidade_destino' => 'required',
//        'id_estado_destino' => 'required',
        'valor_item' => 'required',
        'status' => 'required'

    ];

}
