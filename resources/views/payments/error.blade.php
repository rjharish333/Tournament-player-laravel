<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
	<style>
		@import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
		@import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
	</style>
	<link rel="stylesheet" href="{{asset('assets/css/thankyou.css')}}">
</head>
<body>
	<header class="site-header" id="header">
		<h1 class="site-header__title" data-lead-id="site-header-title">Payment Canceled!</h1>
	</header>

	<div class="main-content">
		<i class="fa fa-check main-content__checkmark" id="checkmark"></i>

		@if(session()->has('error'))
		<div class="alert alert-danger alert-dismissible fade show">
		  {{ session()->get('error') }}
		</div>
		@endif
		<p class="main-content__body" data-lead-id="main-content-body">Your payment is canceled, please try again</p>
		<p class="main-content__body">
			<a href="{{route('login')}}"> Click to login </a>
		</p>
	</div>

	<footer class="site-footer" id="footer">
		<p class="site-footer__fineprint" id="fineprint">Copyright ©2023 | All Rights Reserved</p>
	</footer>
</body>
</html>