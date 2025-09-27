<!DOCTYPE html>
	<html lang="en">

	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	   
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="theme-color" content="#0134d4">
		<meta name="csrf-token" content="{{ csrf_token() }}">
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

		@yield('css')


	</head>
    <body>
         <!---------- Preloader ----------------->
	    <div id="preloader">
	        <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
	    </div>
	    <!---------------------------------------------->

	    <div class="internet-connection-status" id="internetStatus"></div>
        <!-- Dark mode switching -->
	    <div class="dark-mode-switching">
	        <div class="d-flex w-100 h-100 align-items-center justify-content-center">
	            <div class="dark-mode-text text-center">
	                <svg class="bi bi-moon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
	                    <path fill-rule="evenodd" d="M14.53 10.53a7 7 0 0 1-9.058-9.058A7.003 7.003 0 0 0 8 15a7.002 7.002 0 0 0 6.53-4.47z"></path>
	                </svg>
	                <p class="mb-0">Switching to dark mode</p>
	            </div>
	            <div class="light-mode-text text-center">
	                <svg class="bi bi-brightness-high" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
	                    <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"></path>
	                </svg>
	                <p class="mb-0">Switching to light mode</p>
	            </div>
	        </div>
	    </div>
	    <!-- RTL mode switching -->
	    <div class="rtl-mode-switching">
	        <div class="d-flex w-100 h-100 align-items-center justify-content-center">
	            <div class="rtl-mode-text text-center">
	                <svg class="bi bi-text-right" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
	                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm4-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
	                </svg>
	                <p class="mb-0">Switching to RTL mode</p>
	            </div>
	            <div class="ltr-mode-text text-center">
	                <svg class="bi bi-text-left" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
	                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
	                </svg>
	                <p class="mb-0">Switching to default mode</p>
	            </div>
	        </div>
	    </div>
	    <!-- Setting Popup Overlay -->
	    <div id="setting-popup-overlay"></div>
	    <!-- Setting Popup Card -->
	    <div class="card setting-popup-card shadow-lg" id="settingCard">
	        <div class="card-body">
	            <div class="container">
	                <div class="setting-heading d-flex align-items-center justify-content-between mb-3">
	                    <p class="mb-0">Settings</p>
	                    <div class="btn-close" id="settingCardClose"></div>
	                </div>
	                
	                <div class="single-setting-panel">
	                    <div class="form-check form-switch mb-2">
	                        <input class="form-check-input" type="checkbox" id="darkSwitch">
	                        <label class="form-check-label" for="darkSwitch">Dark mode</label>
	                    </div>
	                </div>
	                <div class="single-setting-panel">
	                    <div class="form-check form-switch">
	                        <input class="form-check-input" type="checkbox" id="rtlSwitch">
	                        <label class="form-check-label" for="rtlSwitch">RTL mode</label>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

       
    		@include('include.header_welcome')
		
        @yield('content')

		
    		@include('include.footer_welcome')
		
       
        <!-- Scripts -->
        
	    <script src="{{ asset('js/slideToggle.min.js')}}"></script>
	    <script src="{{ asset('js/internet-status.js')}}"></script>
	    <script src="{{ asset('js/tiny-slider.js')}}"></script>
	    <script src="{{ asset('js/baguetteBox.min.js')}}"></script>
	    {{-- <script src="{{ asset('js/countdown.js')}}"></script> --}}
	    <script src="{{ asset('js/rangeslider.min.js')}}"></script>
	    <script src="{{ asset('js/vanilla-dataTables.min.js')}}"></script>
	    <script src="{{ asset('js/index.js')}}"></script>
	    <script src="{{ asset('js/magic-grid.min.js')}}"></script>
	    <script src="{{ asset('js/dark-rtl.js')}}"></script>
	    <script src="{{ asset('js/active.js')}}"></script>
		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
	    <!-- PWA -->
	    <script src="{{ url('upup.min.js')}}"></script>
		<script>
			UpUp.start({
				'cache-version': 'v2',
				'content-url': 'https://app.ptgib.co.id/',

				'content': 'Cannot reach site. Please check your internet connection.',
				'service-worker-url': 'https://app.ptgib.co.id/upup.sw.min.js'
			});
		</script>
		@yield('js')
    </body>
</html>