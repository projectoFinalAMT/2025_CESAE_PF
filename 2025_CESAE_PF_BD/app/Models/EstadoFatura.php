<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoFatura extends Model
{
    protected $table = 'estado_faturas';

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'nomeEstadoFatura'
    ];
}
