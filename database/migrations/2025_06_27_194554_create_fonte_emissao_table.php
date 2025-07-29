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
        Schema::create('fonte_emissao', function (Blueprint $table) {
            $table->id();
            $table->string('fonte');
            $table->integer('numero_de_fontes');
            $table->integer('numero_de_coletas');
            $table->string('parametros')->nullable();
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
        Schema::dropIfExists('fonte_emissao');
    }
};
