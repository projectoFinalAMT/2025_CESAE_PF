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
        Schema::table('financas', function (Blueprint $table) {
            $table->dropColumn('dataVencimento');    // remove a coluna

            $table->dropForeign(['metodos_pagamentos_id']); // remove a FK
            $table->dropColumn('metodos_pagamentos_id');    // remove a coluna

            $table->dropForeign(['cursos_id']); // remove a FK
            $table->dropColumn('cursos_id');    // remove a coluna
            
            $table->dropForeign(['modulos_id']); // remove a FK
            $table->dropColumn('modulos_id');    // remove a coluna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financas', function (Blueprint $table) {
            $table->date('dataVencimento');

            $table->unsignedBigInteger('metodos_pagamentos_id');
            $table->foreign('metodos_pagamentos_id')->references('id')->on('metodos_pagamentos')->onDelete('cascade');

            $table->unsignedBigInteger('cursos_id');
            $table->foreign('cursos_id')->references('id')->on('cursos')->onDelete('cascade');

            $table->unsignedBigInteger('modulos_id');
            $table->foreign('modulos_id')->references('id')->on('modulos')->onDelete('cascade');
        });
    }
};
