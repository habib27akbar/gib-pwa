<!----------------- Menu SideBar ------------------------------------------->
	    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
	        <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	        <div class="offcanvas-body p-0">

	            <div class="sidenav-wrapper">
	                <div class="sidenav-profile bg-gradient">
	                    <div class="sidenav-style1"></div>
	                    <div class="user-profile"><img src="{{ asset('img/core-img/logo_profile.png') }}" alt=""></div>
	                    <div class="user-info">
	                        <h6 class="user-name mb-0">Gibrig Indonesia Bersih</h6>
	                    </div>
	                </div>

	                <ul class="sidenav-nav ps-0">
	                    <li><a href="{{ route('home') }}"><i class="bi bi-house-door"></i>Beranda</a></li>
						@if (Auth::user()->level == 'customer')
							<li><a href="{{ route('profile.index') }}"><i class="bi bi-person"></i>Profile</a></li>
							<li><a href="{{ route('catalog.index') }}"><i class="bi bi-book"></i>e-Catalog</a></li>
							<li><a href="{{ route('produk.index') }}"><i class="bi bi-gear"></i>Produk</a></li>
							<li><a href="{{ route('komplain.index') }}"><i class="bi bi-chat-dots"></i>Komplain</a></li>
							<li><a href="{{ route('kontak.index') }}"><i class="bi bi-envelope"></i>Kontak</a></li>
						@endif
	                    @if (Auth::user()->level == 'teknisi')
							<li><a href="{{ route('kunjungan.index') }}"><i class="bi bi-map"></i>Kunjungan Komplain</a></li>
	                    	<li><a href="{{ route('kunjungan.index') }}"><i class="bi bi-map"></i>Kunjungan Rutin</a></li>
						@endif
	                    
                        <li>
                            <div class="night-mode-nav"><i class="bi bi-moon"></i>Night Mode
                                <div class="form-check form-switch">
                                    <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                                </div>
                            </div>
	                    </li>
	                    <li>
							<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<i class="bi bi-box-arrow-right"></i> Logout
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</li>
	                </ul>

	            </div>
	        </div>
	    </div>
	    <!----------------------------------------------------------->