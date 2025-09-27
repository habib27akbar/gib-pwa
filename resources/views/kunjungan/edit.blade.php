@extends('layouts.master')
<<<<<<< HEAD
@section('title','Kunjungan Teknisi')
@section('css')
<style>
.product-title{
	font-size: 12px;
}
</style>
	
@endsection
@section('content')

        <div class="page-content-wrapper py-3">
            @include('include.admin.alert')
			@php
				$begin = new DateTime($kunjungan->tgl_mulai);
				$end = new DateTime($kunjungan->tgl_selesai);
				$end->setTime(0, 0, 1);
				$interval = new DateInterval('P1D');
				//$interval = DateInterval::createFromDateString(false);
				$period = new DatePeriod($begin, $interval, $end); 
				$a = 0;  
				$get_tgl = request()->get('tgl')?request()->get('tgl'):date('Y-m-d');
			@endphp

			
			<!-- Pagination-->
			<div class="shop-pagination pb-3">
				<div class="container">
					<h7 style="color:black;"><center>{{ $kunjungan->nama_customer }}<br/>{{ $kunjungan->alamat }}</center></h7>
					

					<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPeriode">
						+ Tambah Kunjungan
					</button>

					<div class="modal fade" id="modalPeriode" tabindex="-1" aria-labelledby="modalPeriodeLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<form action="{{ route('kunjungan.update', ['kunjungan' => $kunjungan->id_komplain_kunjungan]) }}" method="post" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<input type="hidden" name="id_produk" value="{{ $kunjungan->id_produk }}">
							<input type="hidden" name="serial_number" value="{{ $kunjungan->serial_number }}">
								<div class="modal-content">

									<div class="modal-header">
										<h5 class="modal-title" id="modalPeriodeLabel">Tambah Kunjungan</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>

									<div class="modal-body">
										<div class="form-group">
								
											<label class="form-label" style="color: black">Tanggal</label>
											<select class="form-control" name="tanggal" required>
												<option value=""></option>
												@foreach ($period as $item)
													<option {{ $get_tgl == $item->format('Y-m-d')?'selected':'' }} value="{{ $item->format('Y-m-d') }}">{{ $item->format('d/m/Y') }}</option>
													
												@endforeach
											</select>
										</div>

										<div class="form-group">
								
											<label class="form-label" style="color: black">File/Gambar</label>
											<input type="file" class="form-control" name="gambar">
										</div>

										

										{{-- <div class="form-group mb-3">
											<div class="d-flex align-items-center gap-3">
												<div>
													<label for="file-input" style="cursor: pointer;">
														<img 
															src="{{ asset('img/camera-icon.jpg') }}" 
															style="width: 80px; transition: opacity 0.3s ease, transform 0.3s ease;" 
															class="camera-icon"
															alt="Camera Icon">
													</label>
													<input 
														style="opacity: 0; position: absolute; width: 1px; height: 1px;" 
														capture 
														id="file-input-tambah"
														class="form-control" 
														type="file" 
														name="gambar" 
														accept="image/*" 
														onchange="loadFile(event)">
												</div>
												<div>
													<img id="preview" style="display: none; max-width: 100px; margin-top: 10px;" />
												</div>
											</div>

											<input type="hidden" name="gambar_old">
											<input type="hidden" id="latitude" name="latitude" readonly>
											<input type="hidden" id="longitude" name="longitude" readonly>
										</div> --}}

										<div class="form-group">
								
											<label class="form-label" style="color: black">Catatan</label>
											<input type="text" class="form-control" name="catatan" required>
											
										</div>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>

								</div>
							</form>
						</div>
					</div>
					
                    <div class="d-flex align-items-center justify-content-between">
                        {{-- <a href="{{ route('kunjungan.create') }}" class="btn btn-primary">Tambah</a> --}}
                         <input type="text" id="search-input" class="form-control" placeholder="Cari kunjungan...">
                    </div>
                            
						
				</div>
			</div>

            <div class="shop-pagination pb-3">
				<div class="container">
					<div class="card">
						<div class="card-body p-2">
							<div class="d-flex align-items-center justify-content-between"><small class="ms-1 showing-info"></small>
								<form action="#">
									<select class="pe-4 form-select form-select-sm" id="defaultSelectSm" name="defaultSelectSm" aria-label="Default select example">
										<option value="newest" selected>Sort by Newest</option>
										<option value="oldest">Sort by Older</option>
										
									</select>
								</form>
							</div>
                            
						</div>
                        
					</div>
				</div>
			</div>

           

            

			<div class="top-products-area product-list-wrap">
				<div class="container">
					<div class="row g-3">

                        <div class="col-12">
                            <div class="card single-product-card">
                                <div class="card-body">
                                    <h3 style="text-align: center">Loading..</h3>
                                </div>
                            </div>
                        </div>
						
					</div>
				</div>
			</div>


			<div class="shop-pagination pt-3">
				<div class="container">
					<div class="card">
						<div class="card-body py-3">
							<nav aria-label="Page navigation example">
								<ul class="pagination pagination-two justify-content-center">
									No Data
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
			@foreach ($kunjungan_teknisi as $kun)
				<div class="modal fade" id="editData{{ $kun->id }}" tabindex="-1" aria-labelledby="modalPeriodeLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<form action="{{ route('kunjungan.update', ['kunjungan' => $kunjungan->id_komplain_kunjungan]) }}" method="post" enctype="multipart/form-data">
						@csrf
						@method('PUT')
							<div class="modal-content">
								<input type="hidden" name="id" value="{{ $kun->id }}">
								<input type="hidden" name="act" value="update">
								<input type="hidden" name="id_kunjungan_rutin" value="{{ $kun->id_kunjungan_rutin }}">
								<input type="hidden" name="id_produk" value="{{ $kun->id_produk }}">
								<input type="hidden" name="serial_number" value="{{ $kun->serial_number }}">
								<div class="modal-header">
									<h5 class="modal-title" id="modalPeriodeLabel">Ubah Kunjungan</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<div class="modal-body">
									<div class="form-group">
							
										<label class="form-label" style="color: black">Tanggal</label>
										<select class="form-control" name="tanggal" required>
											<option value=""></option>
											@foreach ($period as $item)
												<option {{ $kun->tanggal == $item->format('Y-m-d')?'selected':'' }} value="{{ $item->format('Y-m-d') }}">{{ $item->format('d/m/Y') }}</option>
												
											@endforeach
										</select>
									</div>

									

									{{-- <div class="form-group mb-3">
										<div class="d-flex align-items-center gap-3">
											<div>
												<label for="file-input" style="cursor: pointer;">
													@php
														$image = $kun->gambar ? asset('img/kunjungan/'.$kun->gambar):asset('img/camera-icon.jpg');
													@endphp
													<img 
														src="{{ $image }}" 
														style="width: 80px; transition: opacity 0.3s ease, transform 0.3s ease;" 
														class="camera-icon"
														alt="Camera Icon">
												</label>
												<input 
													style="opacity: 0; position: absolute; width: 1px; height: 1px;" 
													capture 
													id="file-input-{{ $kun->id }}" 
													class="form-control" 
													type="file" 
													name="gambar" 
													accept="image/*" 
													onchange="loadFile(event)">
											</div>
											<div>
												<img id="preview" style="display: none; max-width: 100px; margin-top: 10px;" />
											</div>
										</div>

										<input type="hidden" name="gambar_old" value="{{ $kun->gambar }}">
										<input type="hidden" id="latitude" name="latitude" readonly>
										<input type="hidden" id="longitude" name="longitude" readonly>
									</div> --}}

									<div class="form-group">
								
										<label class="form-label" style="color: black">File/Gambar</label>
										<input type="file" class="form-control" name="gambar">
										<input type="hidden" name="gambar_old" value="{{ $kun->gambar }}">
										<input type="hidden" id="latitude" name="latitude" readonly>
										<input type="hidden" id="longitude" name="longitude" readonly>
									</div>

									<div class="form-group">
							
										<label class="form-label" style="color: black">Catatan</label>
										<input type="text" class="form-control" name="catatan" value="{{ $kun->catatan }}" required>
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>

							</div>
						</form>
					</div>
				</div>
			@endforeach
		</div>
@section('js')
<script>
	// function loadFile(event) {
	// 	// Ambil div container terdekat dari input yang berubah
	// 	const container = event.target.closest('.d-flex');
	// 	const cameraIcon = container.querySelector('.camera-icon');

	// 	// Fade out
	// 	cameraIcon.style.opacity = 0;
	// 	cameraIcon.style.transform = 'scale(0.95)';

	// 	// Ganti gambar setelah delay
	// 	setTimeout(function() {
	// 		cameraIcon.src = URL.createObjectURL(event.target.files[0]);
	// 		cameraIcon.onload = function() {
	// 			cameraIcon.style.opacity = 1;
	// 			cameraIcon.style.transform = 'scale(1)';
	// 		};
	// 	}, 300);
	// }
	function loadFile(event, previewId) {
		let output = document.getElementById(previewId);
		output.src = URL.createObjectURL(event.target.files[0]);
		output.style.display = 'block';
	}
    document.addEventListener("DOMContentLoaded", function () {
        loadProducts();

        document.getElementById("defaultSelectSm").addEventListener("change", function () {
            loadProducts(this.value);
        });
    });




function loadProducts(sort = 'newest', page = 1, search = '', idKunjunganRutin = null) {
    let apiUrl = `{{ url('/api/kunjungan_teknisi') }}?sort=${sort}&page=${page}&search=${encodeURIComponent(search)}`;
    //console.log(apiUrl);
	var idKunjunganRutin = "{{ $kunjungan->id_komplain_kunjungan }}";
    if (idKunjunganRutin) {
        apiUrl += `&id_kunjungan_rutin=${idKunjunganRutin}`;
    }
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const kunjunganContainer = document.querySelector(".top-products-area .container .row");
            kunjunganContainer.innerHTML = "";

            if (data.data.length > 0) {
                data.data.forEach(kunjungan => {
                    const assetPath = "{{ asset('img/kunjungan/') }}";
                    const urlPath = "{{ url('/kunjungan/') }}";
					const idData = kunjungan.id;
                    kunjunganContainer.innerHTML += `
                        <div class="col-12">
                            <div class="card single-product-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <!-- Gambar Kunjungan (Kiri & Kanan) -->
                                        <div class="card-side-img d-flex">
                                            <!-- Gambar Utama -->
                                            ${kunjungan.gambar ? `
                                                <a class="product-thumbnail me-2" data-bs-toggle="modal" data-bs-target="#editData${idData}">
                                                    <img src="${assetPath}/${kunjungan.gambar}">
                                                </a>
                                            ` : ''}

                                           
                                        </div>

                                        <!-- Konten -->
                                        <div class="card-content px-4 py-2">
                                            <a class="product-title d-block text-truncate mt-0" data-bs-toggle="modal" style="font-size:11px;" data-bs-target="#editData${idData}">
                                               ${kunjungan.tanggal}
												<br/>
                                              Catatan: ${kunjungan.catatan ? formatCatatan(kunjungan.catatan) : ''}

                                            </a>
                                            
                                            
                                            
                                        </div>

										
										
                                    </div>
                                </div>
                            </div>
                        </div>

                    `;
                });

                document.querySelector(".showing-info").innerText = `Menampilkan ${data.data.length} dari ${data.total}`;
            } else {
                document.querySelector(".showing-info").innerText = "Tidak ada hasil yang ditemukan.";
            }

            updatePagination(data);
        })
        .catch(error => console.error("Error fetching products:", error));
}
function formatCatatan(text) {
    const words = text.split(' ');
    const chunkSize = 7;
    let result = '';

    for (let i = 0; i < words.length; i += chunkSize) {
        const chunk = words.slice(i, i + chunkSize).join(' ');
        result += chunk + '<br>';
    }

    return result.trim();
}
function formatTanggal(tgl) {
    const date = new Date(tgl);
    const pad = n => n.toString().padStart(2, '0');
    const shortYear = date.getFullYear().toString().slice(-2); // ambil dua digit terakhir
    return `${pad(date.getDate())}/${pad(date.getMonth() + 1)}/${shortYear}`;
}

// Fungsi debounce untuk mencegah request berulang saat mengetik
function debounce(func, delay) {
    let timer;
    return function () {
        const context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(context, args), delay);
    };
}

// Event listener untuk input pencarian
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");

    if (searchInput) {
        searchInput.addEventListener("keyup", debounce(function () {
            const searchQuery = this.value.trim();
            loadProducts('newest', 1, searchQuery);
        }, 500)); // Tunggu 500ms sebelum memanggil API
    }
});


function updatePagination(data) {
    const paginationContainer = document.querySelector(".pagination");
    paginationContainer.innerHTML = "";

    if (data.prev_page_url) {
        paginationContainer.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadProducts('${document.getElementById("defaultSelectSm").value}', ${data.current_page - 1})">&laquo;</a></li>`;
    }

    for (let i = 1; i <= data.last_page; i++) {
        paginationContainer.innerHTML += `<li class="page-item ${i === data.current_page ? "active" : ""}">
            <a class="page-link" href="#" onclick="loadProducts('${document.getElementById("defaultSelectSm").value}', ${i})">${i}</a>
        </li>`;
    }

    if (data.next_page_url) {
        paginationContainer.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadProducts('${document.getElementById("defaultSelectSm").value}', ${data.current_page + 1})">&raquo;</a></li>`;
    }
}
</script>
@endsection  

=======
@section('title','Kunjungan')
@section('content')

        <div class="page-content-wrapper py-3">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="mb-3">Formulir Kunjungan (Ubah)</h5>
						<div class="contact-form">
							<form action="{{ route('kunjungan.update', ['kunjungan' => $kunjungan->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
								
								<iframe 
										id="embedMaps"
										width="100%"
										height="400"
										frameborder="0"
										style="border:0"
										src="https://maps.google.com/maps?q={{ $kunjungan->latitude }},{{ $kunjungan->longitude }}&output=embed"
										allowfullscreen>
								</iframe>
								<div class="form-group mb-3">
									
									<label for="file-input">
										<img src="{{ asset('img/camera-icon.jpg') }}" style="width: 35%" onclick="getLocation()" alt="Camera Icon">
									</label>
									<input style="opacity: 0; position: absolute; width: 1px; height: 1px;" capture id="file-input" class="form-control" type="file" name="gambar" accept="image/*" onchange="loadFile(event)">
									<img id="preview" style="{{ $kunjungan->gambar?'display:block;':'display: none;' }} max-width: 100px; margin-top: 10px;"  src="{{ asset('img/kunjungan/'.$kunjungan->gambar) }}" />
									<input type="hidden" name="gambar_old" value="{{ $kunjungan->gambar }}">
									<input type="hidden" id="latitude" name="latitude" value="{{ $kunjungan->latitude }}" readonly>
									<input type="hidden" id="longitude" name="longitude" value="{{ $kunjungan->longitude }}" readonly>
									
								</div>

								<div class="form-group mb-3">
									
									<label for="file-input-galeri">
										<img src="{{ asset('img/1375106.png') }}" style="width: 14%" onclick="getLocation()" alt="Camera Icon">
									</label>
									<input style="opacity: 0; position: absolute; width: 1px; height: 1px;" id="file-input-galeri" class="form-control" type="file" name="gambar_galeri" accept="image/*" onchange="loadFileGaleri(event)">
									<img id="preview_galeri" style="{{ $kunjungan->gambar_galeri?'display:block;':'display: none;' }} max-width: 100px; margin-top: 10px;" src="{{ asset('img/kunjungan/'.$kunjungan->gambar_galeri) }}" />
									<input type="hidden" name="gambar_galeri_old" value="{{ $kunjungan->gambar_galeri }}">
									
									
								</div>

								<div class="form-group mb-3">
									<input type="text" name="alamat" required class="form-control" placeholder="Tempat" value="{{ $kunjungan->alamat }}">
								</div>
								<div class="form-group mb-3">
									<textarea class="form-control" name="catatan" cols="30" rows="10" placeholder="Catatan">{{ $kunjungan->catatan }}</textarea>
								</div>
								@if ($absensi)
									<i class="bi bi-check-square-fill" style="color:green; margin-bottom:10px"></i> Sudah Absen
								@endif
								<button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
							</form>
							@if ($absensi)
							@else
								<form method="POST" action="{{ route('kunjungan.destroy', ['kunjungan' => $kunjungan->id]) }}">
									
									@method('DELETE')
									@csrf
									<button style="margin-top: 10px; background-color:red;" onclick="return confirm('Apakah anda yakin ingin hapus kunjungan ini?')" class="btn btn-danger w-100">Hapus</button>
										
									
								</form>	
							@endif
							
						</div>
					</div>
				</div>
			</div>
		</div>
@section('js')
<script>
	function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
				var mapSrc = `https://maps.google.com/maps?q=${position.coords.latitude},${position.coords.longitude}&output=embed`;
				document.getElementById("embedMaps").src = mapSrc;
            }, function(error) {
                console.error("Error mendapatkan lokasi: ", error);
                alert("Gagal mendapatkan lokasi. Pastikan GPS diaktifkan.");
            });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }
    }
    function loadFile(event) {
        const output = document.getElementById("preview");
        output.style.display = "block";
        output.src = URL.createObjectURL(event.target.files[0]);
        
    }

	function loadFileGaleri(event) {
        const output = document.getElementById("preview_galeri");
        output.style.display = "block";
        output.src = URL.createObjectURL(event.target.files[0]);
        
    }
</script>
@endsection
>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e
@endsection