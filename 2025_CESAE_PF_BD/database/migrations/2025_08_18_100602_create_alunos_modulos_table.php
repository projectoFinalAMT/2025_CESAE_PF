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
        Schema::create('alunos_modulos', function (Blueprint $table) {
            $table->id();
            $table->decimal('notaAluno')->nullable();
            $table->unsignedBigInteger('modulos_id');
            $table->foreign('modulos_id')->references('id')->on('modulos');
            $table->unsignedBigInteger('alunos_id');
            $table->foreign('alunos_id')->references('id')->on('alunos');
            $table->unsignedBigInteger('estado_alunos_id');
            $table->foreign('estado_alunos_id')->references('id')->on('estado_alunos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos_modulos');
    }
};
