@extends('template')

@section('title')
    Importação de Dados.
@stop

@section('css')
    <!-- css Específico -->
	<link rel="stylesheet" type="text/css" href="{{asset('css/importExcel.css')}}">
@stop

@section('content')
	<br>
	<div id="messages">

	</div>
	<form id="form-import" class="form-horizontal text-center" method="post" action="{{url('api/importar-dados')}}" enctype="multipart/form-data">
		@csrf
		<legend class="row">Importar Dados de arquivos Excel</legend>
		<div class="campos-form">
			<div class="row form-group">
				<label class="col-md-12 control-label" for="filebutton">Selecione um arquivo</label>
				<div class="col-md-12">
					<input id="file-input" name="file" class="input-file" type="file">
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-12">
					<button type="submit" id="btn-importar" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> importar</button>
				</div>
			</div>
		<div>
	</form>

	<div class="col-md-12">
		<a href="{{url('/historico-municipios')}}" class="link-ver-importados"><i class="fa fa-share"></i> Ver dados já importados</a>
	</div>
@stop

@section('js')
	<script type="text/javascript">
        $('#form-import').ajaxForm(function(retorno) { 
        	
        	if(retorno.error){
        		var errors = '';
        		retorno.error.file.forEach(function($erro){
        			errors += $erro+'<br>';
        		});
        		
        		$('#messages').html("<div class='alert alert-danger text-center'>" + errors + "</div>");
        	}else if(retorno.success){
        		$('#messages').html("<div class='alert alert-success text-center'>" + retorno.success + "</div>");
        	}

            console.log(retorno);
        });	
	</script>
@stop