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
        Schema::create('infraestruturas', function (Blueprint $table) {
            $table->id();
            $table->integer('conjunto_id');
            $table->text('conjunto_nome'); 
            $table->integer('ordem')->default(0);
            $table->enum('tipo', ['texto', 'imagem']);
            $table->text('conteudo'); // Caminho ou texto
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infraestruturas');
    }
};
