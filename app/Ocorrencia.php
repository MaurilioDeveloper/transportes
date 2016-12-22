<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $table = 'ocorrencias';

    protected $guarded = ['id'];

    static $rules = [
        'data' => 'required',
        'id_tipo_ocorrencia' => 'required',
        'id_usuario' => 'required',
    ];


}
