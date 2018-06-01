<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoMunicipio;
use App\Http\Requests\FileFormRequest;
use Validator;
use \Excel;
use DB;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
    	$rules = [
    		'file' => 'required | mimes:xlsx,xls'
    	];
    	$messages = [
    		'file.required' => 'Selecione um arquivo.',
    		'file.mimes' 	=> 'Formato de Arquivo inválido. apenas .xlsx ou .xls.'
    	];

    	$validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(),'status' => 422]);
        }

        $dados = $this->extrairDados($request->file('file'));

        foreach ($dados as $dado) {
        	$historico = [
        		"c_ano" 			=> $dado['c_ano'],
        		"c_resenha" 		=> $dado['c_resenha'],
        		"c_partes"			=> $dado['c_partes'],
        		"c_valor_real"		=> intval($dado['c_valor_real']),
        		"c_objeto"    		=> $dado['c_objeto'],
        		"c_cod_municipio"	=> $dado['c_cod_municipio'],
        		"c_nome_municipio"	=> $dado['c_nome_municipio']
        	];

        	HistoricoMunicipio::updateOrCreate($historico);
        }

        $anos = HistoricoMunicipio::select('c_ano')->distinct()->get();
        foreach($anos as $ano){
        	DB::select("select preencherTblTotais('$ano->c_ano')");
        }
        
    	return response()->json(['success'=>'Importação ocorrida com sucesso!','status' => 200]);
    }

    public function extrairDados($file)
    {

        $file_name = $file->getClientOriginalName();
        $file->move('files',$file_name);

        $dados = Excel::load('files/'.$file_name,function($reader){
			        	$reader->all();
			    })->get();

        return $dados;
    }

}
