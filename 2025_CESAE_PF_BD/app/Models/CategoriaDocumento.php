<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaDocumento extends Model
{
    protected $table = 'categoria_documentos';

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'categoria_documento_id');
    }
}
