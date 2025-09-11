<?php

namespace App\Models;

use App\Models\Curso;
use App\Models\Instituicao;
use App\Models\Recebimento;
use Illuminate\Database\Eloquent\Model;

class Financa extends Model
{

    protected $table="financas";
    protected $fillable=['descricao','quantidade_horas','valor_hora','valor_semImposto','IVAPercetagem','baseCalculoIRS','IRSTaxa','observacoes','dataEmissao','dataPagamento','valor','id_curso','id_modulo','users_id','instituicoes_id','estado_faturas_id'];

    // Relação com recebimentos
    public function recebimento() {
        return $this->hasOne(Recebimento::class, 'financas_id');
    }

    // Relação com instituições
    public function instituicao(){
        return $this->belongsTo(Instituicao::class, 'instituicoes_id');
    }

    // Relação com estadoFatura
    public function estadoFatura(){
    return $this->belongsTo(EstadoFatura::class, 'estado_faturas_id');
}

    // Relação com curso
    public function curso(){ // não é chave estrangeira
    return $this->belongsTo(Curso::class, 'id_curso', 'id');
}

}
