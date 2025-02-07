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
        Schema::create('times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_torneios')->onDelete('cascade');
            $table->foreignId('advogado_id')->nullable()->constrained('advogados')->onDelete('set null');
            $table->string('nome');
            $table->enum('status', ['pendente', 'ativo', 'desativado'])->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('times');
    }
};