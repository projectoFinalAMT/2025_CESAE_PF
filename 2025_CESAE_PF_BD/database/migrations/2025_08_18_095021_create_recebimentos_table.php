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
        Schema::create('recebimentos', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor');
            $table->date('dataRecebimento');
            $table->text('observacoes')->nullable();
            $table->unsignedBigInteger('financas_id');
            $table->foreign('financas_id')->references('id')->on('financas');
            $table->unsignedBigInteger('metodos_pagamentos_id');
            $table->foreign('metodos_pagamentos_id')->references('id')->on('metodos_pagamentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recebimentos');
    }
};
