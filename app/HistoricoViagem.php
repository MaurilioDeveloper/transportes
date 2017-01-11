<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoViagem extends Model
{
    protected $table = 'historico_viagens';

    protected $guarded = ['id'];
}
