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
        'data_hoje' => 'required',
        'data_inicio' => 'required',
        'data_fim' => 'required',
        'cidade_origem' => 'required',
        'estado_origem' => 'required|min:2|max:2',
        'cidade_destino' => 'required',
        'estado_destino' => 'required|min:2|max:2',
        'valor_item' => 'required',
        'cor' => 'required',
        'identificacao' => 'required',
        'valor_total' => 'required',

    ];

}
