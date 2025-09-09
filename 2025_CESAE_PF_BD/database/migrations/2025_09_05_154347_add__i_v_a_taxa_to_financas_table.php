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
            $table->decimal('IVATaxa')->after('IVAPercetagem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financas', function (Blueprint $table) {
            $table->dropColumn('IVATaxa');
        });
    }
};
