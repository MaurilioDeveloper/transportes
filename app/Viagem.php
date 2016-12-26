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
        3 => 'Concluida',
        4 => 'Cancelada'
    ];
}
