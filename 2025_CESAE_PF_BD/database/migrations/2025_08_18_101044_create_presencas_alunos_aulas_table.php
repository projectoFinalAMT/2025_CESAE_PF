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
        Schema::create('presencas_alunos_aulas', function (Blueprint $table) {
            $table->id();
            $table->boolean('presenca')->nullable();
            $table->string('empenho')->nullable();
            $table->string('comportamento')->nullable();
            $table->unsignedBigInteger('alunos_id');
            $table->foreign('alunos_id')->references('id')->on('alunos');
            $table->unsignedBigInteger('aulas');
            $table->foreign('aulas')->references('id')->on('aulas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presencas_alunos_aulas');
    }
};
