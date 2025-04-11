<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilmeApi extends Model
{
    protected $fillable = [
        'nome',
        'genero',
        'ano_lancamento',
    ];
}
