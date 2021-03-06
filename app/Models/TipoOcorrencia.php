<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoOcorrencia extends Model
{
    protected $table = 'tipo_ocorrencias';

    protected $guarded = ['id'];

    static $rules = [
        'nome' => 'required'
    ];
}
