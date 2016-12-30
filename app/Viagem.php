<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    protected $table = 'viagens';

    protected $guarded = ['id'];

    const STATUS = [
        1 => 'Aguardando Inicio',
        2 => 'Em Viagem',
        3 => 'Concluída',
        4 => 'Cancelada'
    ];

    static $rules = [
        'status' => 'required',
        'cidade_origem' => 'required',
        'cidade_destino' => 'required',
        'estado_origem' => 'required',
        'estado_destino' => 'required'
    ];
}
