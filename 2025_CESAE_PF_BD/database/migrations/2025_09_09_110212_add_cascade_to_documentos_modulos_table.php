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
        Schema::table('documentos_modulos', function (Blueprint $table) {
            $table->dropForeign(['documentos_id']);
            $table->dropForeign(['modulos_id']);

            // Adiciona as foreign keys novamente com cascade
            $table->foreign('documentos_id')
                  ->references('id')->on('documentos')
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
        Schema::table('documentos_modulos', function (Blueprint $table) {
                       // Remove as FKs com cascade
            $table->dropForeign(['documentos_id']);
            $table->dropForeign(['modulos_id']);

            // Se quiser, recrie as FKs antigas sem cascade
            $table->foreign('documentos_id')
                  ->references('id')->on('documentos');

            $table->foreign('modulos_id')
                  ->references('id')->on('modulos');

        });
    }
};
