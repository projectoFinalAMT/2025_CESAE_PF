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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
        // Dados do evento
        $table->string('title')->nullable(); // título exibido no calendário, em caso de aula pode ser nullable pois vai buscar o nome do modulo
        $table->dateTime('start');
        $table->dateTime('end');

        // Relacionamentos
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
            $table->unsignedBigInteger('modulos_id')->nullable();
            $table->foreign('modulos_id')->references('id')->on('modulos');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
