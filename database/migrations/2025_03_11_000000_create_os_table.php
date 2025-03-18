<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsTable extends Migration
{
    public function up()
    {
        Schema::create('os', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposta_id')->constrained('propostas')->onDelete('cascade');
            $table->foreignId('perfil_id')->nullable()->constrained('perfis')->onDelete('cascade');
            $table->json('metodologia_documentos');
            $table->json('equipamentos_necessarios');
            $table->text('observacao')->nullable();
            $table->boolean('lixeira')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('os');
    }
}