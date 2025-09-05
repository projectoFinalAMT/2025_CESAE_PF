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
        Schema::table('recebimentos', function (Blueprint $table) {
            $table->dropForeign(['metodos_pagamentos_id']); // remove a FK
            $table->dropColumn('metodos_pagamentos_id');    // remove a coluna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recebimentos', function (Blueprint $table) {
            $table->unsignedBigInteger('metodos_pagamentos_id');
            $table->foreign('metodos_pagamentos_id')->references('id')->on('metodos_pagamentos')->onDelete('cascade');
        });
    }
};
