<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatoDocumento extends Model
{
     protected $table = 'formato_documentos';

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'formato_documento_id');
    }
}
