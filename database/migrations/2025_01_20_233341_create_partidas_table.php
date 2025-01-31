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
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_torneios')->onDelete('cascade');
            $table->foreignId('torneio_id')->constrained('torneios')->onDelete('cascade');
            $table->foreignId('time_id_casa')->constrained('times')->onDelete('cascade');
            $table->foreignId('time_id_fora')->constrained('times')->onDelete('cascade');
            $table->enum('resultado', ['casa', 'fora', 'empate'])->nullable();
            $table->string('local');
            $table->integer('gol_casa')->nullable();
            $table->integer('gol_fora')->nullable();
            $table->dateTime('data_marcada');
            $table->enum('status', ['pendente', 'jogando', 'terminada', 'cancelada']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};