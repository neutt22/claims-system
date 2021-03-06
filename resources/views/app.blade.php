<!DOCTYPE html>
<html>
<head>
	<title>Claims System</title>
	<link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
	<link href="{{ asset('css/hint.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/main.css') }}" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Lato:300,100' rel='stylesheet' type='text/css'>

	@yield('custom-css')
</head>
<body>
	@yield('content')

	<footer>
		@yield('footer')
	</footer>

	@yield('custom-js')
</body>
</html>