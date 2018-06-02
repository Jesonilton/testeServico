<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConveniosMunicipio extends Model
{
	protected $table = 'convenios_municipios';
    protected $fillable = ["c_ano","c_resenha","c_partes","c_valor_real","c_objeto","c_cod_municipio","c_nome_municipio"];
}
