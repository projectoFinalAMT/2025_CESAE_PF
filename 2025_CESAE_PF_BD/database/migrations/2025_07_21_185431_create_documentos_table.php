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
            $table->date('dataValidade');
            $table->string('formatoDocumento');
            $table->unsignedBigInteger('categoriaDocumentos_id');
            $table->foreign('categoriaDocumentos_id')->references('id')->on('categoriaDocumentos');
            $table->unsignedBigInteger('formato_documentos_id');
            $table->foreign('formato_documentos_id')->references('id')->on('formato_documentos');
            $table->unsignedBigInteger('estado_documentos_id');
            $table->foreign('estado_documentos_id')->references('id')->on('estado_documentos');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
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
