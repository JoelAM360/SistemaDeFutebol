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
        Schema::create('jogadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('advogado_id')->constrained('advogados')->onDelete('cascade');
            $table->foreignId('time_id')->nullable()->constrained('times');
            $table->string('img_perfil');
            $table->enum('posicao', ['goleiro','defensor','meio-campo','atacante']);
            $table->integer('dorsal');
            $table->enum('isCapitao', ['nao', 'sim']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogadores');
    }
};
