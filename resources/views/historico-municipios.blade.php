@extends('template')

@section('title')
    Filtro de Dados.
@stop

@section('css')
    <!-- css Específico -->
	<link rel="stylesheet" type="text/css" href="{{asset('css/historico-municipios.css')}}">
@stop

@section('content')
	<legend>Consuta de Municipios e Convênios</legend>
	<div class="col-md-12 div-select-municipios">
		<select id="select-municipios" class="form-control">
		</select>
	</div>

	<div class="select-anos">
		<div class="form-group">
			<div class="col-md-12"> 
				<label class="col-md-2" for="radios-0">
				  	<input type="radio" class="btn-radio" name="radios" id="radios-0" value="2015">
				  	2015
				</label> 
				<label class="col-md-2" for="radios-1">
				  	<input type="radio" class="btn-radio" name="radios" id="radios-1" value="2016">
				  	2016
				</label> 
				<label class="col-md-2" for="radios-2">
				 	<input type="radio" class="btn-radio" name="radios" id="radios-2" value="2017">
				  	2017
				</label> 
				<label class="col-md-2" for="radios-3">
				  	<input type="radio" class="btn-radio" name="radios" id="radios-3" value="2018">
				  	2018
				</label>
				<label class="col-md-2" for="radios-3">
				  	<input type="radio" class="btn-radio" name="radios" id="radios-3" value="todos">
				  	Todos
				</label>
			</div>
		</div>
	</div>
	<div class="div-tbl-geral-municipios col-md-12">
		<table id="tbl-geral-municipios" class="table table-bordered col-md-12" >
			<thead>
				<tr>
					<th scope="col-md-3">Resenha</th>
					<th scope="col-md-4">Objeto</th>
					<th scope="col-md-2">Partes</th>
					<th scope="col-md-3">Valor</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		<!-- Paginator -->
		<div id="paginator">
			<ul class="" id="pagination" class="pagination-sm"></ul>
		</div>
	</div>

<!-- 
	<legend>Totais de Anos</legend>
	<div class="div-tbl-totais-anos">
		<table id="tbl-geral-municipios" class="table table-bordered display" >
			<thead>
				<tr>
					<th scope="col-md-3">Ano</th>
					<th scope="col-md-4">Quantidade</th>
					<th scope="col-md-2">Total</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>

	</div> -->

@stop

@section('js')
	<script type="text/javascript" charset="utf8" src="{{asset('/js/esimakin-twbs-pagination/jquery.twbsPagination.min.js')}}"></script>


	<script type="text/javascript">
		$(document).ready(function()
		{

			$.get("api/nome-municipios", function(retorno)
			{
				options = '<option value="todos">Todos</option>';
				retorno.nome_municipios.forEach(function(municipio){
					options += "<option value="+ municipio.c_cod_municipio +">"+municipio.c_nome_municipio+"</option>";
				});

		      	$("#select-municipios").html(options);

	 		});

			listarTodos();

			$('.btn-radio').on('click',function(){

				$.get( "api/filtrar-municipio-data" ,{ano: $(this).val() ,cod_municipio: $("#select-municipios").val() } ).done(function(retorno){
						exibirNaTabelaMunicipios(retorno.municipios);
		 		});
					
			});

			$("#select-municipios").on('change', function()
			{	
				if($("#select-municipios").val() == 'todos'){
					listarTodos();
				}else{
					$.get( "api/filtrar-municipio" ,{ cod_municipio: $("#select-municipios").val() } ).done(function(retorno){
						exibirNaTabelaMunicipios(retorno.municipios);
			 		});
				}
			});

			function addPaginate(dados)
			{
				if(dados.data.length > 4){
					$("#paginator").html("<ul id='pagination' class='pagination-sm'></ul>");

					var $pagination = $('#pagination');
					var defaultOpts = {
				        totalPages: 5
				    };
		            var totalPages = dados.last_page;
		            var currentPage = dados.current_page;
		            $pagination.twbsPagination('destroy');
		            $pagination.twbsPagination($.extend({}, defaultOpts, {
		                startPage: currentPage,
		                totalPages: totalPages,
		                onPageClick: function (event, page) {
					        $url = "api/listar-todos?page="+page;
					        if(page != currentPage){
					        	$.get($url, function(retorno){
									exibirNaTabelaMunicipios(retorno.municipios);
						        });	
					        }

					    }
		            }));
	            }
			}

			function exibirNaTabelaMunicipios(municipios)
			{
				$("#tbl-geral-municipios > tbody").html('');
				if(municipios.data.length > 0){
					
					addPaginate(municipios);

					municipios.data.forEach(function(municipio){
						var newRow = $("<tr>");

						var cols = "";	
						cols += '<td>'+ municipio.c_resenha +'</td>';
						cols += '<td>'+ municipio.c_objeto +'</td>';
						cols += '<td>'+ municipio.c_partes +'</td>';
						cols += '<td>'+ municipio.c_valor_real +'</td>';

						newRow.append(cols);	    
						$("#tbl-geral-municipios > tbody").append(newRow);
					});

				}else{
					$("#tbl-geral-municipios > tbody").html("<td colspan='4'><h4>Nada Encontrado</h4></td>");
					$("#paginator").html("");
				}
			}

			function listarTodos()
			{
				$.get("api/listar-todos").done(function(retorno)
				{
					exibirNaTabelaMunicipios(retorno.municipios);

		 		});
			}

		});

	</script>
@stop