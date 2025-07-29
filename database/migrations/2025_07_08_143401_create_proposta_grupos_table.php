<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('proposta_grupos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposta_id');
            $table->string('nome');
            $table->timestamps();

            $table->foreign('proposta_id')->references('id')->on('propostas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposta_grupos');
    }
};
