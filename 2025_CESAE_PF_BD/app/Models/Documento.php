<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'nome',
        'caminhoDocumento',
        'dataValidade',
        'categoria_documento_id',
        'formato_documentos_id',
        'descricao', 
        'estado_documentos_id',
        'users_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaDocumento::class, 'categoria_documento_id');
    }

    public function formatoDocumento()
    {
        return $this->belongsTo(FormatoDocumento::class, 'formato_documentos_id');
    }

    public function modulos()
    {
        return $this->belongsToMany(
            Modulo::class,
            'documentos_modulos',
            'documentos_id',
            'modulos_id'
        );
    }
}

