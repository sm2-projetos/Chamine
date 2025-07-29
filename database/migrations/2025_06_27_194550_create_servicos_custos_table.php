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
        Schema::create('servicos_custos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->integer('coletas_por_fontes');
            $table->integer('qtd_fontes');
            $table->decimal('valor_por_fonte', 10, 2);
            $table->decimal('total', 12, 2);
            $table->unsignedBigInteger('id_proposta');
            $table->timestamps();

            $table->foreign('id_proposta')->references('id')->on('propostas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos_custos');
    }
};
