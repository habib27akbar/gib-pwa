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
	                    <li>
                            <a href="{{ route('welcome_page.index') }}"><i class="bi bi-house-door"></i>Beranda</a></li>
						
							<li><a href="{{ route('welcome.visi_misi') }}"><i class="bi bi-person"></i>Tentang GIB</a></li>
							<li><a href="{{ route('catalog_welcome.index') }}"><i class="bi bi-book"></i>e-Catalog</a></li>
							<li><a href="{{ route('berita.index') }}"><i class="bi bi-gear"></i>Berita</a></li>
							<li><a href="{{ route('agenda.index') }}"><i class="bi bi-chat-dots"></i>Agenda</a></li>
							<li><a href="{{ route('video.index') }}"><i class="bi bi-envelope"></i>Video</a></li>
						
							<li><a href="{{ route('workshop.index') }}"><i class="bi bi-map"></i>Workshop</a></li>
	                    	
						
	                    
                        <li>
                            <div class="night-mode-nav"><i class="bi bi-moon"></i>Night Mode
                                <div class="form-check form-switch">
                                    <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                                </div>
                            </div>
	                    </li>
	                    
	                </ul>

	            </div>
	        </div>
	    </div>