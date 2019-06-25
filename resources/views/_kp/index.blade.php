<!DOCTYPE html>
<html lang="ru">
<head>
	<title>OneTech</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="OneTech shop project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{csrf_token()}}">

	<link rel="stylesheet" href="{{asset('css/app.css')}}">

</head>

<body>

<div class="super_container">

	<!-- Modals -->
@include('_kp.positions.modals.default')

<!-- Header Section Starts -->
@include('_kp.positions.header.default')
<!-- Header Section Ends -->

	<!-- Main Container Starts -->
@include('_kp.positions.content.default')
<!-- Main Container Ends -->

	<!-- Footer Section Starts -->
@include('_kp.positions.footer.default')
<!-- Footer Section Ends -->

</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzy4Bx5gHQSf4kHFQMo_mFhKlfeL_3lU8"></script>
<script src="{{asset('js/app.js')}}" charset="utf-8"></script>

</body>

</html>