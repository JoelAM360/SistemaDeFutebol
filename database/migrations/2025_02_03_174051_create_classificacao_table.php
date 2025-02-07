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
        Schema::create('classificacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('torneio_id')->constrained('torneios')->onDelete('cascade');
            $table->foreignId('time_id')->constrained('times')->onDelete('cascade');
            $table->integer('vitorias');
            $table->integer('derrotas');
            $table->integer('empates');
            $table->integer('gol_marcados')->nullable();
            $table->integer('gol_sofridos')->nullable();
            $table->integer('gol_diferenca')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classificacaos');
    }
};