<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidatos extends Model
{
    protected $fillable = ['nome', 'nascimento', 'cep', 'cidade', 'estado'];
}
