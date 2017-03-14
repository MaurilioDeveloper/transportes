<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contatos';

    protected $guarded = ['id'];

//    protected $fillable = ['nome', 'email', 'telefone', 'id_parceiro'];
}
