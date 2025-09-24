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
        Schema::table('alunos_modulos', function (Blueprint $table) {

            $table->dropForeign(['alunos_id']);
            $table->dropForeign(['modulos_id']);

            // recriar com cascade
            $table->foreign('alunos_id')
                  ->references('id')->on('alunos')
                  ->onDelete('cascade');

            $table->foreign('modulos_id')
                  ->references('id')->on('modulos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alunos_modulos', function (Blueprint $table) {
            // reverte para sem cascade
            $table->dropForeign(['alunos_id']);
            $table->dropForeign(['modulos_id']);

            $table->foreign('alunos_id')
                  ->references('id')->on('alunos');

            $table->foreign('modulos_id')
                  ->references('id')->on('modulos');
        });
    }
    
};
