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
	    <link rel="manifest" href="{{ asset('manifest.json') }}">
	    <!------------------------------------------------------>




	</head>

	<body>


	     <!---------- Preloader ----------------->
	    <div id="preloader">
	        <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
	    </div>
	    <!---------------------------------------------->

	    <div class="internet-connection-status" id="internetStatus"></div>

	    <div class="header-area" id="headerArea">
	        <div class="container">
	            <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">

	                <!------------ Logo ---------------->
	                <div class="logo-wrapper"><a href="{{ route('home') }}"><img src="{{ asset('img/core-img/logo.png') }}" alt=""></a></div>
	                <!---------------------------------------------->

	                <!------------------ Navbar Toggle -------------------->
	                <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
	            </div>
	            <!-- # Header Five Layout End -->
	        </div>
	    </div>

        @include('include.sidebar')

         <div class="page-content-wrapper">




	        <!--------------- Slider  --------------------->
	        <div class="tiny-slider-one-wrapper">
	            <div class="tiny-slider-one">
	                <!------------------------------------------->
	                <div>
	                    <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('img/slider/slide01.jpg') }}')">
	                        <div class="h-100 d-flex align-items-center text-center">
	                            <div class="container">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!------------------------------------------->
	                <div>
	                    <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('img/slider/slide02.jpg') }}')">
	                        <div class="h-100 d-flex align-items-center text-center">
	                            <div class="container">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!------------------------------------------->
	                <div>
	                    <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('img/slider/slide03.jpg') }}')">
	                        <div class="h-100 d-flex align-items-center text-center">
	                            <div class="container">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!------------------------------------------->
	                <div>
	                    <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('img/slider/slide03.jpg') }}')">
	                        <div class="h-100 d-flex align-items-center text-center">
	                            <div class="container">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!------------------------------------------->
	                <div>

	                    <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('img/slider/slide01.jpg') }}')">
	                        <div class="h-100 d-flex align-items-center text-center">
	                            <div class="container">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!------------------------------------------->

	            </div>
	        </div>
	        <div class="pt-3"></div>
	        <!--------------------------------------------------------------------->




	        <!--------------ICON ----------------------->
	        <div class="container direction-rtl">
	            <div class="card mb-3">
	                <div class="card-body">
	                    <div class="row g-3">
						@if (Auth::user()->level == 'customer')
	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="{{ route('catalog.index') }}">
	                                    <div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/catalog.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">e-Catalog</p>
	                            </div>
	                        </div>
						

	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="{{ route('produk.index') }}">
	                                    <div class="card mx-auto bg-primary  "><img src="{{ asset('img/icons/produk.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">Produk Saya</p>
	                            </div>
	                        </div>


	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="{{ route('komplain.index') }}">
	                                    <div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/komplain.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">Komplain</p>
	                            </div>
	                        </div>
						@endif

							@if (Auth::user()->level == 'teknisi')
								<div class="col-4">
									<div class="feature-card mx-auto text-center">
										<a href="{{ route('kunjungan_komplain.index') }}">
											<div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/kunjungan.png') }}" alt=""></div>
										</a>
										<p class="mb-0">Kunjungan Komplain</p>
									</div>
								</div>
								<div class="col-4">
									<div class="feature-card mx-auto text-center">
										<a href="{{ route('kunjungan.index') }}">
											<div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/kunjungan.png') }}" alt=""></div>
										</a>
										<p class="mb-0">Kunjungan Rutin</p>
									</div>
								</div>
							@endif
	                        

						@if (Auth::user()->level == 'customer')
	                       



	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
<<<<<<< HEAD
	                                <a href="{{ route('kontak.index') }}">
	                                    <div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/kontak.png') }}" alt=""></div>
=======
	                                <a href="{{ route('kunjungan.index') }}">
	                                    <div class="card mx-auto bg-secondary "><img src="{{ asset('img/icons/kunjungan.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">Kunjungan</p>
	                            </div>
	                        </div>


	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="profile.html">
	                                    <div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/profile.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">Profile</p>
	                            </div>
	                        </div>



	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="kontak.html">
	                                    <div class="card mx-auto bg-secondary "><img src="{{ asset('img/icons/kontak.png') }}" alt=""></div>
>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e
	                                </a>
	                                <p class="mb-0">Kontak</p>
	                            </div>
	                        </div>
						@endif
						@if (Auth::user()->level != 'customer')
							<div class="col-4">
								<div class="feature-card mx-auto text-center">
									<a href="{{ route('absen.index') }}">
										<div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/absen.png') }}" alt=""></div>
									</a>
									<p class="mb-0">Absen</p>
								</div>
							</div>
						@endif
						<div class="col-4">
							<div class="feature-card mx-auto text-center">
								<a href="{{ route('profile.index') }}">
									<div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/profile.png') }}" alt=""></div>
								</a>
								<p class="mb-0">Profile</p>
							</div>
						</div>
						<div class="col-4">
							<div class="feature-card mx-auto text-center">
								<a href="{{ route('scan_produk.index') }}">
									<div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/scan.png') }}" alt=""></div>
								</a>
								<p class="mb-0">Scan Produk</p>
							</div>
						</div>
						

	                    </div>
	                </div>
	            </div>
	        </div>
	        <!------------------------------------------->
			<br/>





	        <!----------------------- Menu Footer ------------------------->
	        @include('include.footer')
        </div>


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
	    <script src="{{ asset('js/pwa.js')}}"></script>
        <script>
            function refreshCaptcha() {
                fetch('{{ route("captcha.refresh") }}')
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector("img[alt='CAPTCHA Image']").src = data.captcha;
                    });
            }
        </script>
	</body>

	</html>