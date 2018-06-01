<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoMunicipio;

class HistoricoMunicipiosController extends Controller
{
	public function listarTodos()
	{
		$municipios = self::query()->paginate(5);

		return response()->json(['municipios'=> $municipios, 'status'=> 200]);
	}

	public function buscarNomeMunicipios()
	{
		$municipios = HistoricoMunicipio::select('c_nome_municipio','c_cod_municipio')
						->distinct()
						->get();

		return response()->json(['nome_municipios' => $municipios, 'status' => 200]);
	}

	public function filtrarPorMunicipio(Request $request)
	{

		$municipios = self::query()->where('c_cod_municipio',$request->cod_municipio)->paginate(5);

		return response()->json(['municipios'=> $municipios, 'status'=> 200]);
	}

	public function filtrarPorMunicipioData(Request $request)
	{
		$municipios = null;

		if($request->cod_municipio == 'todos' && $request->ano == 'todos'){

			return $this->listarTodos();

		}else if($request->cod_municipio != 'todos' && $request->ano == 'todos'){

			return $this->filtrarPorMunicipio($request);

		}else if($request->cod_municipio == 'todos' && $request->ano != 'todos'){

			$municipios = self::query()->where('c_ano',$request->ano)->paginate(5);

		}else{

			$municipios = self::query()->where('c_cod_municipio',$request->cod_municipio)->where('c_ano',$request->ano)->paginate(5);

		}

		return response()->json(['municipios'=> $municipios, 'status'=> 200]);
	}

	private static function query()
	{
		return HistoricoMunicipio::select('c_resenha','c_objeto','c_valor_real','c_partes');
	} 
}
