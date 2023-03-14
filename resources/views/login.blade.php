<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Welcome to Tournament Players</title>

	<!-- Favicons -->
	<link rel="shortcut icon" href="assets/img/logo/favicon.png">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>
	<div class="main-wrapper">
	
		<div class="login-page">
			<div class="login-body container">
				<div class="loginbox">
					<div class="login-right-wrap">
						<div class="account-header">
							<div class="account-logo text-center mb-4">
								<a href="/">
									<img src="{{asset('assets/img/login.png')}}" alt="" class="img-fluid">
								</a>
							</div>
						</div>
						<div class="login-header">
							<h3 class="text-center">Login <span><b>Tournament Players</b></span></h3>
							<p class="text-muted text-center">Access to our dashboard</p>
						</div>
						@if(session()->has('error'))
						    <div class="alert alert-danger alert-dismissible fade show">
						        {{ session()->get('error') }}
						    </div>
						@endif

						@if(session()->has('success'))
						    <div class="alert alert-success alert-dismissible fade show">
						        {{ session()->get('success') }}
						    </div>
						@endif
						<form method="post" action="{{route('authenticate')}}">
							@csrf
							<div class="form-group">
								<label class="control-label">Email</label>
								<input class="form-control" name="email" type="text" placeholder="Enter your Email">
							</div>
				
							<div class="form-group mb-4">
								<label class="control-label">Password</label>
								<input class="form-control" name="password" type="password" placeholder="Enter your password">
							</div>
							<div class="text-center">
								<button class="btn btn-primary btn-block account-btn" type="submit">Login</button>
							</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- jQuery -->
	<script src="assets/js/jquery-3.5.0.min.js"></script>

	<!-- Bootstrap Core JS -->
<!--	<script src="assets/js/popper.min.js"></script> -->
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/admin.js"></script>

</body>

</html>