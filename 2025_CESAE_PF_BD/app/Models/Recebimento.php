<?php

namespace App\Models;

use App\Models\Financa;
use App\Models\Instituicao;
use Illuminate\Database\Eloquent\Model;

class Recebimento extends Model
{
    protected $table = 'recebimentos';

    protected $fillable = [
        'valor',
        'dataRecebimento',
        'observacoes',
        'financas_id',
        'instituicoes_id'
    ];

    // Relação com finanças
    public function financa()
    {
        return $this->belongsTo(Financa::class, 'financas_id');
    }

    // Relação com instituições
     public function instituicao()
    {
        return $this->belongsTo(Instituicao::class, 'instituicoes_id');
    }
}
