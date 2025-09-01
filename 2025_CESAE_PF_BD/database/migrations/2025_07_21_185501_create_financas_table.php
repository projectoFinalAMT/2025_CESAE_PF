<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financas', function (Blueprint $table) {
            $table->id();
            $table->string('numeroFatura');
            $table->text('observacoes')->nullable();
            $table->date('dataVencimento');
            $table->date('dataEmissao');
            $table->date('dataPagamento')->nullable();
            $table->decimal('valor');
            $table->decimal('IVAPercetagem')->nullable();
            $table->decimal('baseCalculoIRS')->nullable();
            $table->decimal('IRSTaxa')->nullable();
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
            $table->unsignedBigInteger('instituicoes_id');
            $table->foreign('instituicoes_id')->references('id')->on('instituicoes');
            $table->unsignedBigInteger('metodos_pagamentos_id');
            $table->foreign('metodos_pagamentos_id')->references('id')->on('metodos_pagamentos');
            $table->unsignedBigInteger('cursos_id');
            $table->foreign('cursos_id')->references('id')->on('cursos');
            $table->unsignedBigInteger('modulos_id')->nullable();
            $table->foreign('modulos_id')->references('id')->on('modulos');
            $table->unsignedBigInteger('estado_faturas_id');
            $table->foreign('estado_faturas_id')->references('id')->on('estado_faturas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financas');
    }
};
