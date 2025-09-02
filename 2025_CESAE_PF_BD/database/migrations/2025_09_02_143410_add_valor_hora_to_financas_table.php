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
            $table->decimal('quantidade_horas')->after('id_curso')->nullable();
            $table->decimal('valor_hora')->after('quantidade_horas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financas', function (Blueprint $table) {
            $table->dropColumn('quantidade_horas');
            $table->dropColumn('valor_hora');
        });
    }
};
