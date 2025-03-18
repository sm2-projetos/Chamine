<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasTable extends Migration
{
    public function up()
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_empresa');
            $table->text('analise_critica');
            $table->string('fonte_emissao');
            $table->integer('numero_fontes');
            $table->string('parametros');
            $table->text('servicos_custos');
            $table->text('observacoes')->nullable();
            $table->string('status')->default('Em Análise');
            $table->boolean('lixeira')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('propostas');
    }
}