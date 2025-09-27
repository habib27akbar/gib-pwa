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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <!------------------- Favicon ---------------------->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/icons/icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/icons/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('img/icons/icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icons/icon-180x180.png') }}">
    <!--------------------------------------------->
    <!-- CSS Libraries-->
    <link rel="stylesheet" href="{{ asset('/msg/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/msg/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('/msg/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/msg/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/msg/css/lineicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/msg/css/magnific-popup.css') }}">
    <!-- Stylesheet-->
    <link rel="stylesheet" href="{{ asset('/msg/css/style.css') }}">
    <!-- Web App Manifest-->
    <link rel="manifest" href="{{ url('manifest.json') }}">
  </head>
  <body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{ route('kunjungan_komplain.index') }}">
            <svg class="bi bi-arrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
            </svg></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Komplain</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
            {{-- <span></span><span></span><span></span> --}}
        </div>
      </div>
    </div>
    
    <div class="page-content-wrapper">
        <!-- Live Chat Intro-->
      <div class="live-chat-intro mb-3" style="color: white">
        {{ $kunjungan->nama_customer }}
        <br/>
        {{ $kunjungan->alamat }}
        <br/>
        {{ $kunjungan->no_telp }}
      </div>
      <!-- Support Wrapper-->
     
      <div class="support-wrapper py-3">
        <div class="container">
          <!-- Live Chat Wrapper-->
          <div class="live-chat-wrapper">
            <!-- Agent Message Content-->
            <div class="agent-message-content d-flex align-items-start">
              <!-- Agent Thumbnail-->
              {{-- <div class="agent-thumbnail me-2 mt-2"><img src="img/bg-img/9.jpg" alt=""></div> --}}
              <!-- Agent Message Text-->
              <div class="agent-message-text">
                <div class="d-block">
                  <p>
                    {{ $kunjungan->pesan }}
                    @if ($kunjungan->gambar)
                      <a href="{{ asset('img/komplain/'.$kunjungan->gambar) }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('img/1375106.png') }}" style="width: 5%" alt="Camera Icon">
                      </a>
                    @endif
                  </p>
                 
                </div>
                <span>{{ $kunjungan->nama_lengkap.' '.TanggalHelper::get_date_time($kunjungan->created_at) }}</span>
              </div>
            </div>
            @foreach ($koordinasi as $item)
            
                <!-- User Message Content-->
                <div class="{{ Auth::user()->id == $item['id_user'] ?'user-message-content':'agent-message-content d-flex align-items-start'}}">
                    <!-- User Message Text-->
                    <div class="{{ Auth::user()->id == $item['id_user'] ?'user':'agent'}}-message-text">
                        <div class="d-block">
                            <p>
                                @if ($item->hapus)
                                   <i>--Dihapus--</i> 
                                @else
                                    {{ $item['catatan'] }}
                                @endif
                            </p>
                            <span>
                                @if (Auth::user()->id != $item['id_user'])
                                    {{ $item->nama_lengkap }}
                                @endif
                                {{ TanggalHelper::get_date_time($item['created_at']) }}
                                @if (Auth::user()->id == $item['id_user'])
                                    @if ($item->hapus)
                                    @else
                                        @if ($kunjungan->sts ==0)
                                            <form method="POST" action="{{ route('kunjungan_komplain.update', ['kunjungan_komplain' => $kunjungan->id_komplain_kunjungan]) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_chat" value="{{ $item['id'] }}">
                                                <input type="hidden" name="delete" value="ok">
                                                <button type="submit" class="btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        @endif   
                                    @endif
                                @endif
                            </span>
                        </div>
                        
                    </div>
                </div>
            @endforeach

            
            
            
            
          </div>
        </div>
      </div>
    </div>
    @if ($kunjungan->sts ==0)
       <!-- Type Message Form-->
        <div class="type-text-form">
            <form action="{{ route('kunjungan_komplain.update', ['kunjungan_komplain' => $kunjungan->id_komplain_kunjungan]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group file-upload mb-0">
                <input type="file"><i class="lni lni-plus"></i>
                </div>
                <textarea class="form-control" name="message" cols="30" rows="10" placeholder="Type your message"></textarea>
                <button type="submit">
                <svg class="bi bi-arrow-right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                </svg>
                </button>
            </form>
        </div>
    @else
    
        <h5 style="text-align: center"><i style="color:green;" class="fa fa-check">Komplain Telah Selesai</i></h5>
    @endif
    
    <!-- All JavaScript Files-->
    <script src="{{ asset('/msg/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/msg/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/msg/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('/msg/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('/msg/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/msg/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('/msg/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('/msg/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('/msg/js/jquery.passwordstrength.js') }}"></script>
    <script src="{{ asset('/msg/js/dark-mode-switch.js') }}"></script>
    <script src="{{ asset('/msg/js/no-internet.js') }}"></script>
    <script src="{{ asset('/msg/js/active.js') }}"></script>
    <script src="{{ url('upup.min.js')}}"></script>
    <script>
        UpUp.start({
            'cache-version': 'v2',
            'content-url': 'https://app.ptgib.co.id/',

            'content': 'Cannot reach site. Please check your internet connection.',
            'service-worker-url': 'https://app.ptgib.co.id/upup.sw.min.js'
        });
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                window.scrollTo(0, document.body.scrollHeight);
            }, 100);
        });
    </script>
  </body>
</html>