<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{csrf_token()}}">

		<title>{{$global_data['template']['metatags']['title'] or ''}}</title>
		<meta name="description" content="{{$global_data['template']['metatags']['description'] or ''}}">
		<meta name="keywords" content="{{$global_data['template']['metatags']['keywords'] or ''}}">

		<!-- Google Web Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Oswald:400,700,300" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400" rel="stylesheet" type="text/css">

		<!-- Template CSS Files  -->
		<link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
	</head>
	<body>

	<!-- Header Section Starts -->
		@include('_raduga.positions.header.default')
	<!-- Header Section Ends -->
	<!-- Main Container Starts -->
		@include('_raduga.positions.content.default')
	<!-- Main Container Ends -->
	<!-- Footer Section Starts -->
		@include('_raduga.positions.footer.default')
	<!-- Footer Section Ends -->

	<!-- Template JS Files -->
	<script src="{{URL::asset('js/app.js')}}" charset="utf-8"></script>
	</body>
</html>