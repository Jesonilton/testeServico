<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotaisTable extends Model
{
	protected $table = 'totais';
    protected $fillable = ["municipio","ano","quantidade","total"];
}
