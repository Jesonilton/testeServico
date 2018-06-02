<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalConvenios extends Model
{
	protected $table = 'totais_convenios';
    protected $fillable = ["municipio","ano","quantidade","total"];
}
