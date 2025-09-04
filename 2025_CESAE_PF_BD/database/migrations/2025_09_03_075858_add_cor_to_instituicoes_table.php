<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('instituicoes', function (Blueprint $table) {
            $table->string('cor')->nullable()->after('nomeInstituicao');
        });
    }

    public function down(): void
    {
        Schema::table('instituicoes', function (Blueprint $table) {
            $table->dropColumn('cor');
        });
    }
};
