<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('cor');
        });

        Schema::table('modulos', function (Blueprint $table) {
            $table->dropColumn('cor');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('cor')->nullable();
        });

        Schema::table('modulos', function (Blueprint $table) {
            $table->string('cor')->nullable();
        });
    }
};

