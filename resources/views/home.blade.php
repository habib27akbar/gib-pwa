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

	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="catalog.html">
	                                    <div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/catalog.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">e-Catalog</p>
	                            </div>
	                        </div>


	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="produk.html">
	                                    <div class="card mx-auto bg-secondary  "><img src="{{ asset('img/icons/produk.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">Produk</p>
	                            </div>
	                        </div>


	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="komplain.html">
	                                    <div class="card mx-auto bg-primary "><img src="{{ asset('img/icons/komplain.png') }}" alt=""></div>
	                                </a>
	                                <p class="mb-0">Komplain</p>
	                            </div>
	                        </div>



	                        <div class="col-4">
	                            <div class="feature-card mx-auto text-center">
	                                <a href="kunjungan.html">
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
	                                </a>
	                                <p class="mb-0">Kontak</p>
	                            </div>
	                        </div>


	                    </div>
	                </div>
	            </div>
	        </div>
	        <!------------------------------------------->






	        <!----------------------- Menu Footer ------------------------->
	        <div class="footer-nav-area" id="footerNav">
	            <div class="container px-0">



	                <!--------------- Footer Navigation ------------------------>
	                <div class="footer-nav position-relative">
	                    <ul class="h-100 d-flex align-items-center justify-content-between ps-0">


	                        <li class="active"><a href="page-home.html">
	                                <svg class="bi bi-house" width="20" height="20" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
	                                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
	                                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
	                                </svg><span>Beranda</span></a></li>



	                        <li><a href="catalog.html">
	                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
	                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
	                                </svg><span>e-Catalog</span></a></li>



	                        <li><a href="produk.html">
	                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
	                                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
	                                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
	                                </svg><span>Produk</span></a></li>


	                        <li><a href="komplain.html">
	                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
	                                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
	                                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2" />
	                                </svg><span>Komplain</span></a></li>

	                        <li><a href="kunjungan.html">
	                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
	                                    <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.5.5 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103M10 1.91l-4-.8v12.98l4 .8zm1 12.98 4-.8V1.11l-4 .8zm-6-.8V1.11l-4 .8v12.98z" />
	                                </svg><span>Kunjungan</span></a></li>


	                    </ul>
	                </div>
	                <!----------------------------------------------->



	            </div>
	        </div>
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