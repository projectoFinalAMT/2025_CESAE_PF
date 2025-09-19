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
        $table->dropForeign(['financas_id']);
        $table->foreign('financas_id')
              ->references('id')
              ->on('financas')
              ->onDelete('cascade');
    });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recebimentos', function (Blueprint $table) {
        $table->dropForeign(['financas_id']);
        $table->foreign('financas_id')
              ->references('id')
              ->on('financas');
    });
    }
};
