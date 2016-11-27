<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>Home 11</title>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/font-linearicons.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap-theme.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fancybox.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery-ui.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.carousel.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.transitions.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.theme.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.mCustomScrollbar.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/assets/js/slideshow/settings.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/theme.css') }}" media="all"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/responsive.css') }}" media="all"/>

</head>
<body>
<div class="wrap">
	<div id="header">
		
		@include('frontend.partials.main-header')	
		
		@include('frontend.partials.main-menu')
		
	</div>	
	<!-- End Header -->
	<div id="content">
		@yield('content')
	</div>
	<!-- End Content -->
	<div id="footer">
		@include('frontend.partials.footer')
	</div>
	<!-- End Footer -->
</div>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.12.0.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.fancybox.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/TimeCircles.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.countdown.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.bxslider.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/modernizr.custom.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.hoverdir.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/slideshow/jquery.themepunch.revolution.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/slideshow/jquery.themepunch.plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/theme.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
});
</script>
@yield('javascript')
</body>
</html>