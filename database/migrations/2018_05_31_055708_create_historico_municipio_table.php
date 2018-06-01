<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoMunicipioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_municipios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('c_ano');
            $table->text('c_resenha');
            $table->text('c_partes');
            $table->bigInteger('c_valor_real')->nullable();
            $table->text('c_objeto')->nullable();
            $table->string('c_cod_municipio');
            $table->string('c_nome_municipio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_municipios');
    }
}
