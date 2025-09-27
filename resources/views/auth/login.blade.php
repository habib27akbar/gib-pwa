	<!DOCTYPE html>
	<html lang="en">

	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	   
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="theme-color" content="#0134d4">
	    <meta name="apple-mobile-web-app-capable" content="yes">
	    <meta name="apple-mobile-web-app-status-bar-style" content="black">

	    <title>.:: PT. GIB ::.</title>


	    <!----------- Fonts ------------------->
	    <link rel="preconnect" href="https://fonts.gstatic.com">
	    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
	    <!------------------------------------------------------->


	    <!------------------- Favicon ---------------------->
	    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">
	    <link rel="apple-touch-icon" href="{{ asset('img/icons/icon-96x96.png') }}">
		<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/icons/icon-144x144.png') }}">
	    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/icons/icon-152x152.png') }}">
	    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('img/icons/icon-167x167.png') }}">
	    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icons/icon-180x180.png') }}">
	    <!--------------------------------------------->


	    <!----------------------- CSS  -------------------------->
	    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
	    <link rel="stylesheet" href="{{ asset('css/tiny-slider.css') }}">
	    <link rel="stylesheet" href="{{ asset('css/baguetteBox.min.css') }}">
	    <link rel="stylesheet" href="{{ asset('css/rangeslider.css') }}">
	    <link rel="stylesheet" href="{{ asset('css/vanilla-dataTables.min.css') }}">
	    <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}">
	    <link rel="stylesheet" href="{{ asset('style.css') }}">
	    <link rel="manifest" href="{{ url('manifest.json') }}">
		<link rel="stylesheet" href="{{ asset('/msg/css/font-awesome.min.css') }}">
	    <!------------------------------------------------------>




	</head>

	<style>
		html, body {
			height: 100%;
			margin: 0;
			overflow: hidden; /* Mencegah scroll */
		}
	</style>

	<body>


	    <!---------- Preloader ----------------->
	    <div id="preloader">
	        <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
	    </div>
	    <!---------------------------------------------->

	    <div class="internet-connection-status" id="internetStatus"></div>

		@if(true)
	    <!---------------------------------------------->
			<div class="login-wrapper d-flex align-items-center justify-content-center" style="padding-top: 0;padding-bottom:5rem;">
				<div class="custom-container">
					<div class="text-center px-4"><img class="login-intro-img" src="{{ asset('img/bg-img/login_bg.png') }}" alt=""></div>

					<div class="register-form">
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						@if (session('alert-danger'))
							<div class="alert alert-danger">
								{{Session::get('alert-danger')}}	
							</div>
						@endif


						<form action="{{ route('authenticate') }}" method="POST">
							@csrf
							<div class="form-group">
								<input class="form-control" type="text" name="username" placeholder="Username">
							</div>
							<div class="form-group position-relative">
								<input class="form-control" id="psw-input" type="password" name="password" placeholder="Enter Password">
								<div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></div>
							</div>
							<div class="form-group position-relative">
								<img src="{{ captcha_src() }}" alt="CAPTCHA Image"><button type="button" onclick="refreshCaptcha()">🔄</button>
								<input type="text" class="form-control" name="captcha" placeholder="Captcha">
							</div>
							<button class="btn btn-primary w-100" type="submit">LOGIN</button>
							
						</form>
					</div>
					<!---------------------------------------------->



				</div>
			</div>
		@endif

		

		 @include('include.footer_welcome')




	    <!-- All JavaScript Files -->
	    <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
	    <script src="{{ asset('js/slideToggle.min.js')}}"></script>
	    <script src="{{ asset('js/internet-status.js')}}"></script>
	    <script src="{{ asset('js/tiny-slider.js')}}"></script>
	    <script src="{{ asset('js/baguetteBox.min.js')}}"></script>
	    <script src="{{ asset('js/countdown.js')}}"></script>
	    <script src="{{ asset('js/rangeslider.min.js')}}"></script>
	    <script src="{{ asset('js/vanilla-dataTables.min.js')}}"></script>
	    <script src="{{ asset('js/index.js')}}"></script>
	    <script src="{{ asset('js/magic-grid.min.js')}}"></script>
	    <script src="{{ asset('js/dark-rtl.js')}}"></script>
	    <script src="{{ asset('js/active.js')}}"></script>
	    <!-- PWA -->
		<script src="{{ url('upup.min.js')}}"></script>
	    
        <script>
            function refreshCaptcha() {
                fetch('{{ route("captcha.refresh") }}')
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector("img[alt='CAPTCHA Image']").src = data.captcha;
                    });
            }
			UpUp.start({
				'cache-version': 'v2',
				'content-url': 'https://app.ptgib.co.id/',

				'content': 'Cannot reach site. Please check your internet connection.',
				'service-worker-url': 'https://app.ptgib.co.id/upup.sw.min.js'
			});

			
        </script>
	</body>

	</html>