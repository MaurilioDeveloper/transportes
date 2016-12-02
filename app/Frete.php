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
}
