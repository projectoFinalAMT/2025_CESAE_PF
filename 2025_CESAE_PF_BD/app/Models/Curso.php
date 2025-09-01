<?php

namespace App\Models;

use App\Models\Modulo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
     use HasFactory;

    protected $table = 'cursos';
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descrição',
        'duracaoTotal',
        'precoHora',
        'dataInicio',
        'dataFim',
        'instituicoes_id',
        'users_id',
        'estado_cursos_id',
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class, 'instituicoes_id');
    // Relacionamento com Modulos
    public function modulos()
    {
        return $this->hasMany(Modulo::class, 'cursos_id');
    }
}
