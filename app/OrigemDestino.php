<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrigemDestino extends Model
{
    protected $table = 'origens_destinos';

    protected $guarded = ['id'];

    static $rules = [
        'cidade' => 'required',
        'estado' => 'min:2|max:2'
    ];
}
