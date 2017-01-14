<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Blue Gallery Invoicing</title>
	<link rel="stylesheet" type="text/css" href="app.css">
	<link rel="stylesheet" type="text/css" href="/css/app.css">
</head>

<body>
	<div id="loading">
		<a class="button is-primary is-loading">Loading</a>
		<a class="button is-white">Loading</a>
	</div>

	<div id="app" class="wrapper hidden">
		
		@include('modal')
		
		@include('sidebar')

		@include('printable')
		
	</div>

</body>

<script src="{{asset('js/app.js')}}"></script>

</html>