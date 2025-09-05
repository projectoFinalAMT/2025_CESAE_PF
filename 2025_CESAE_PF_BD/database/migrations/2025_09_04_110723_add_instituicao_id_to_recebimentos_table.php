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
             $table->unsignedBigInteger('instituicoes_id');
             $table->foreign('instituicoes_id')->references('id')->on('instituicoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recebimentos', function (Blueprint $table) {
        $table->dropForeign(['instituicoes_id']); // remove a FK
        $table->dropColumn('instituicoes_id');    // remove a coluna
        });
    }
};
