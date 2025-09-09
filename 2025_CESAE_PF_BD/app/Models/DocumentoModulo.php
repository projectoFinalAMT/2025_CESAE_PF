<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoModulo extends Model
{
    protected $table = 'documentos_modulos'; // força o Laravel a usar o nome correto
    public $timestamps = false; // se não tiver created_at/updated_at
    protected $fillable = ['documentos_id', 'modulos_id']; // ajuste conforme sua tabela
}
