<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvenioMunicipioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios_municipios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('c_ano');
            $table->text('c_resenha');
            $table->text('c_partes');
            $table->decimal('c_valor_real', 10, 2)->nullable();
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
        Schema::dropIfExists('convenios_municipios');
    }
}
