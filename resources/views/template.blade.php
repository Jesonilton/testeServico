<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> @yield('title') </title>

	<!-- css Geral -->
	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/template.css')}}">

	@yield('css')

</head>
<body>
	<div class="container-fluid">

		@yield('content')

	</div>

	<!-- Importações de JavaScript -->
	<script src="{{asset('js/jquery-3.3.1.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('js/jquery-form-pluguin.js')}}" type="text/javascript"></script>
	@yield('js')

</body>
</html>