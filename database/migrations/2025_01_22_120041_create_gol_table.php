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
        Schema::create('gols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')->constrained('partidas')->onDelete('cascade');
            $table->integer('tempo');
            $table->foreignId('time_id')->constrained('times')->onDelete('cascade');
            $table->foreignId('jogador_id_marcador')->constrained('jogadores')->onDelete('cascade');
            $table->foreignId('jogador_id_assitente')->nullable()->constrained('jogadores')->onDelete('cascade');
            $table->enum('tipo_de_gol', ['normal','livre', 'penalte', 'gol_contra']);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gol');
    }
};
