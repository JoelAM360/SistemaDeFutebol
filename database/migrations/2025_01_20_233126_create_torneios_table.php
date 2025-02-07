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
        Schema::create('torneios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_torneios')->onDelete('cascade');
            $table->string('nome');
            $table->integer('jornadas');
            $table->integer('quantidade_times');
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->timestamps();
            $table->enum('status', ['ativo', 'desativo'])->default('ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('torneios');
    }
};