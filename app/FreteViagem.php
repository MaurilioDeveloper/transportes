<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreteViagem extends Model
{
    protected $table = 'fretes_viagens';

    protected $guarded = ['id'];
}
