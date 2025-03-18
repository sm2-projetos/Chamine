<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLixeiraToClienteEmpresaTable extends Migration
{
    public function up()
    {
        Schema::table('cliente_empresa', function (Blueprint $table) {
            $table->boolean('lixeira')->default(false);
        });
    }

    public function down()
    {
        Schema::table('cliente_empresa', function (Blueprint $table) {
            $table->dropColumn('lixeira');
        });
    }
}
