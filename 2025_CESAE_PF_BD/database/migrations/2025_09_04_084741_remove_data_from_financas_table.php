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
            $table->dropColumn('numeroFatura');
            $table->dropColumn('quantidade_horas');
            $table->dropColumn('valor_hora');
            $table->dropColumn('IVAPercetagem');
            $table->dropColumn('baseCalculoIRS');
            $table->dropColumn('IRSTaxa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financas', function (Blueprint $table) {
            $table->string('numeroFatura');
            $table->decimal('quantidade_horas')->after('descricao');
            $table->decimal('valor_hora')->after('quantidade_horas');
            $table->decimal('IVAPercetagem')->after('valor_semImposto');
            $table->decimal('baseCalculoIRS')->after('IVAPercetagem');
            $table->decimal('IRSTaxa')->after('baseCalculoIRS');
        });
    }
};
