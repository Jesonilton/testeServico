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
				<label class="col-md-2" for="radios-3">
				  	<input type="radio" class="btn-radio" name="radios" id="radios-3" value="0" checked="checked">
				  	Todos
				</label>
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


	<legend>Totais de Anos</legend>
	<div class="div-tbl-totais-convenios">
		<table id="tbl-totais-convenios" class="table table-bordered display" >
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

	</div>

@stop

@section('js')
	<script type="text/javascript" charset="utf8" src="{{asset('/js/esimakin-twbs-pagination/jquery.twbsPagination.min.js')}}"></script>


	<script type="text/javascript">
		$(document).ready(function()
		{
			//busca os nomes dos municipios para listar no select
			$.get("api/nome-municipios", function(retorno)
			{
				options = '<option value="0">Todos</option>';
				retorno.nome_municipios.forEach(function(municipio){
					options += "<option value="+ municipio.c_cod_municipio +">"+municipio.c_nome_municipio+"</option>";
				});

		      	$("#select-municipios").html(options);
		      	listarTodos();
	 		});

			//filtra os dados por ano
			$('.btn-radio').on('click',function(){
				//metodo responsável pela requisição
				listarTodos();	
			});

			//filtra os dados por municipio
			$("#select-municipios").on('change', function()
			{	
				//metodo responsável pela requisição
				listarTodos();
			});

			function addPaginate(dados)
			{
				//verifica se existem dados
				if(dados.data.length > 4){
					//se a quantidade de dados for maior que 4, exibe o componente de paginação. 
					$("#paginator").show();
					//recebe o componente de paginação
					var $pagination = $('#pagination');
				    //define o total de paginas com base no total de paginas dos dados recebidos. last_page refere-se à ultima pagina dos dados
		            var totalPages = dados.last_page;
		            //define a pagina atual
		            var currentPage = dados.current_page;
		            //define a url que será requisitada na troca de paginas
		            var path = dados.path;
		            //reseta do componente paginate
		            $pagination.twbsPagination('destroy');
		            //cria o componente de paginação
		            $pagination.twbsPagination($.extend({}, {
		                startPage: currentPage,
		                totalPages: totalPages,
		                //metodo invocado a cada troca de páginas
		                onPageClick: function (event, page) {
		                	//prepara a url para buscar os dados do número pagina solicitada pelo cliente
					        $url = path+"?page="+page;
					        //se a pagina solicitada for direntente da pagina atual, a requisição será realizada
					        if(page != currentPage){
					        	//requisição
					        	$.get($url, function(retorno){
					        		//informa qual a página atual
					        		currentPage = page;
					        		//exibe os dados retornados na tela. Para evitar a perca da paginação, informamos true como sinal de que já possui paginação
									exibirNaTabelaMunicipios(retorno.municipios,true);
						        });	
					        }

					    }
		            }));
	            }else{
	            	//oculta o componente de paginação
	            	$("#paginator").hide();
	            }
			}

			function exibirNaTabelaMunicipios(municipios,paginate=false)
			{
				//reseta o corpo da tabela
				$("#tbl-geral-municipios > tbody").html('');
				//verifica se existem dados
				if(municipios.data.length > 0){
					
					//se não tiver paginação, adiciona.
					if(paginate == false){
						addPaginate(municipios);
					}
					//percorre dados
					municipios.data.forEach(function(municipio){
						//abre uma nova linha na tabela
						var newRow = $("<tr>");
						//cria as colunas
						var cols = "";	
						cols += '<td>'+ municipio.c_resenha +'</td>';
						cols += '<td>'+ municipio.c_objeto +'</td>';
						cols += '<td>'+ municipio.c_partes +'</td>';
						cols += '<td>R$'+ municipio.c_valor_real +'</td>';
						//fecha a linha na tabela
						newRow.append(cols);	   
						//adiciona a linha criada á tabela 
						$("#tbl-geral-municipios > tbody").append(newRow);
					});

				}else{
					//é exibido quando não tiver dados
					$("#tbl-geral-municipios > tbody").html("<td colspan='4'><h4>Nada Encontrado</h4></td>");
					//oculta o componente de paginação
					$("#paginator").hide();
				}
			}

			//lista os dados na tabela dos totais dos convênios
			function exibirNaTabelaTotaisConvenios(dados)
			{
				//reseta o corpo da tabela
				$("#tbl-totais-convenios > tbody").html('');
				//verifica se existem dados
				if(dados.length > 0){
					//percorre os dados
					dados.forEach(function(dado){
						//abre uma nova linha na tabela
						var newRow = $("<tr>");
						//cria as colunas
						var cols = "";	
						cols += '<td>'+ dado.ano +'</td>';
						cols += '<td>'+ dado.quantidade +'</td>';
						cols += '<td>R$'+ dado.total +'</td>';
						//fecha a linha na tabela
						newRow.append(cols);	
						//adiciona a linha criada á tabela
						$("#tbl-totais-convenios > tbody").append(newRow);
					});

				}else{
					//é exibido quando não tiver dados
					$("#tbl-totais-convenios > tbody").html("<td colspan='4'><h4>Nada Encontrado</h4></td>");
				}
			}

			//metodo responsável pela requisição
			function listarTodos()
			{
				//captura o municipio selecionado
				var cod_municipio 	= $("#select-municipios").val();
				//captura o ano selecionado
				var ano 			= jQuery("input[name=radios]:checked").val();
				//url da api que será usada na requisição
				var url 			= "api/filtrar/"+cod_municipio+"/"+ano;

				//realiza a requisição na api com o código e o ano
				$.get(url).done(function(retorno)
				{	
					//chamada de metodos que exibem os dados retornados
					exibirNaTabelaMunicipios(retorno.municipios);
					exibirNaTabelaTotaisConvenios(retorno.convenios);
		 		});
			}

		});

	</script>
@stop
