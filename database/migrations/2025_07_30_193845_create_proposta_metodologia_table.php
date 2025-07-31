<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proposta_metodologia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposta_id');
            $table->unsignedBigInteger('metodologia_id');
            $table->timestamps();

            // Relacionamentos (opcional, mas recomendado)
            $table->foreign('proposta_id')->references('id')->on('propostas')->onDelete('cascade');
            $table->foreign('metodologia_id')->references('id')->on('metodologias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposta_metodologia');
    }
};

