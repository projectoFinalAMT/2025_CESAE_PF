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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('caminhoDocumento');
            $table->string('formatoDocumento');
            $table->unsignedBigInteger('categoriaDocumentos_id');
            $table->foreign('categoriaDocumentos_id')->references('id')->on('categoriaDocumentos');
            $table->unsignedBigInteger('intituicoes_id');
            $table->foreign('intituicoes_id')->references('id')->on('intituicoes');
            $table->unsignedBigInteger('cursos_id');
            $table->foreign('cursos_id')->references('id')->on('cursos');
            $table->unsignedBigInteger('modulos_id');
            $table->foreign('modulos_id')->references('id')->on('modulos');
            $table->unsignedBigInteger('utilizadores_id');
            $table->foreign('utilizadores_id')->references('id')->on('utilizadores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
