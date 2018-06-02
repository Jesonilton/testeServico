<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConveniosMunicipio;
use App\Models\TotalConvenios;

class ConveniosMunicipioController extends Controller
{
	//Lista todos os convênios independente de ano ou municipio
	public function listarConvenios()
	{
		$municipios = self::query()->paginate(5);
		$convenios = self::getTotalConveniosPorAno();

		//resposta JSON para o cliente
		return response()->json(['municipios'=> $municipios,'convenios'=>$convenios, 'status'=> 200]);
	}

	//retorna apenas os nomes dos municipios 
	public function buscarNomeMunicipios()
	{
		//busca os municipios ordenando em ordem alfabetica
		$municipios = ConveniosMunicipio::select('c_nome_municipio','c_cod_municipio')
						->distinct()->orderBy('c_nome_municipio')
						->get();

		//resposta JSON para o cliente
		return response()->json(['nome_municipios' => $municipios, 'status' => 200]);
	}

	//lista os convênios por municipio
	public function filtrarPorMunicipio($cod_municipio)
	{
		//retorna os municipios
		$municipios = self::query()->where('c_cod_municipio',$cod_municipio)->paginate(5);
		$totalConvenios = self::getTotailConveniosMunicipio($cod_municipio);
		
		//resposta JSON para o cliente
		return response()->json(['municipios'=> $municipios, 'convenios'=> $totalConvenios, 'status'=> 200]);
	}

	public function filtrar($cod_municipio = 0 , $ano = 0)
	{
		$municipios = null;
		$convenios = null;
		//lista todos os Convênios
		if($cod_municipio == 0 && $ano == 0){

			return $this->listarConvenios();

		//lista os convênios por unicipio
		}else if($cod_municipio != 0 && $ano == 0){

			return $this->filtrarPorMunicipio($cod_municipio);

		//lista os convênios por ano
		}else if($cod_municipio == 0 && $ano != 0){
			$convenios 	= self::getTotalConveniosPorAno($ano);
			$municipios = self::query()->where('c_ano',$ano)->paginate(5);

		//lista os convênios por municipio e por ano
		}else{
			$convenios = self::getTotailConveniosMunicipio($cod_municipio);
			$municipios = self::query()->where('c_cod_municipio',$cod_municipio)->where('c_ano',$ano)->paginate(5);
		}

		//resposta JSON para o cliente
		return response()->json(['municipios' => $municipios, 'convenios' => $convenios,'status'=> 200]);
	}

	//query base de consulta para evitar repetição de código
	private static function query()
	{
		return ConveniosMunicipio::select('c_nome_municipio','c_resenha','c_objeto','c_valor_real','c_partes');
	}

	//lista os convênios por ano
	private static function getTotalConveniosPorAno($ano = ''){
		$convenios = [];

		// se estiver vazio, irá retornas o total de convenio de cada ano
		if(empty($ano)){
			//busca apenas os anos. o distinct() garante que não vem anos repetidos
			$anos = TotalConvenios::select('ano')->distinct()->get();

			foreach ($anos as $ano) {
				//busca o total de convenios feitos em cada ano
				$query = TotalConvenios::where('ano', $ano->ano);
				$convenio = [
					'ano'			=> $ano->ano,
					'quantidade'	=> $query->sum('quantidade'),//quantidade de convênios
					'total'			=> $query->sum('total')//total investido em convênio
				];

				$convenios[] = $convenio;
			}
		}else{
			//busca os convênio do ano informado
			$query = TotalConvenios::where('ano', $ano);

			$convenio = [
				'ano'			=> $ano,
				'quantidade'	=> $query->sum('quantidade'),
				'total'			=> $query->sum('total')
			];

			//passado para array para unificar a forma de leitura dos dados do lado do cliente
			$convenios[] = $convenio;
		}

		return $convenios;
	}

	//lista os convênios por municipio
	private static function getTotailConveniosMunicipio($cod_municipio){

		//retorna apenas o nome do municipio para ser utilizado em uma nova consulta
		$municipio = ConveniosMunicipio::select('c_nome_municipio')->where('c_cod_municipio',$cod_municipio)->first();

		//retorna os convenios dos municipios ordenados pelo ano em que foram feitos
		return  TotalConvenios::select('ano','quantidade','total')
						->where('municipio', $municipio->c_nome_municipio)
						->distinct()
						->orderBy('ano')
						->get();

	}
}
