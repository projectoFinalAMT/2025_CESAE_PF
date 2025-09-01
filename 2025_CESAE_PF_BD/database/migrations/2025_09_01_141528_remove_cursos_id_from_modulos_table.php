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
    Schema::table('modulos', function (Blueprint $table) {
        $table->dropForeign(['cursos_id']); // remove a FK
        $table->dropColumn('cursos_id');    // remove a coluna
    });
}

public function down(): void
{
    Schema::table('modulos', function (Blueprint $table) {
        $table->unsignedBigInteger('cursos_id');
        $table->foreign('cursos_id')->references('id')->on('cursos')->onDelete('cascade');
    });
}
};
