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
            $table->bigInteger('id_curso')->after('IRSTaxa')->nullable();
            $table->bigInteger('id_modulo')->after('id_curso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financas', function (Blueprint $table) {
            $table->dropColumn('id_curso');
            $table->dropColumn('id_modulo');
        });
    }
};
