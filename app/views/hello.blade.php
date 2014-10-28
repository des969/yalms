<!doctype html>
<html lang="en">

<head>
{{ HTML::style('css/main.css'); }}
	<meta charset="UTF-8">
	<title>YaLMS</title>
</head>
<body>
	@extends('sign.signin')


	@section('signin_block')
	@stop
	<nav>{{ link_to_route('course.index', 'Courses') }}</nav>

	<div class="welcome">
        <img src="/images/logo.png">
		<h1>Yet another LMS</h1>
	</div>
</body>
</html>