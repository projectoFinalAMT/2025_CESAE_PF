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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descricao')->nullable();
            $table->decimal('duracaoTotal')->nullable();
            $table->decimal('precoHora');
            $table->date('dataInicio');
            $table->date('dataFim')->nullable();
            $table->unsignedBigInteger('instituicoes_id');
            $table->foreign('instituicoes_id')->references('id')->on('instituicoes')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
            $table->unsignedBigInteger('estado_cursos_id');
            $table->foreign('estado_cursos_id')->references('id')->on('estado_cursos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
