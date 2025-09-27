@extends('layouts.master')
@section('title','Kunjungan')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">	
@endsection
@section('content')

        <div class="page-content-wrapper py-3">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						@include('include.admin.alert')
						{{-- <h5 class="mb-3">Formulir Absensi</h5> --}}
						<div class="contact-form">
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

							<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPeriode">
								+ Tambah Kunjungan
							</button>

							

							<div class="row">
								<div class="col-md-6">
									<select class="pe-4 form-select form-select-sm" id="defaultSelectSm" name="defaultSelectSm" aria-label="Default select example">
										<option value="newest" selected>Sort by Newest</option>
										<option value="oldest">Sort by Older</option>
										
									</select>
								</div>
								<div class="col-md-6">
									<input type="text" style="max-height: 32px;" id="search-input" class="form-control" placeholder="Cari kunjungan..." style="max-width: 300px;">
								</div>
							</div>

							
							<div class="modal fade" id="modalPeriode" tabindex="-1" aria-labelledby="modalPeriodeLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<form action="{{ route('kunjungan.update', ['kunjungan' => $kunjungan->id_komplain_kunjungan]) }}" method="post" enctype="multipart/form-data">
									@csrf
									@method('PUT')
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
													
													<label class="form-label" style="color: black">Produk</label>
													<select class="form-control" name="id_produk" required>
														<option value=""></option>
														@foreach ($item_customer as $item)
															<option value="{{ $item->id_produk }}">{{ $item->judul }}</option>
															
														@endforeach
													</select>
												</div>

												<div class="form-group mb-3">
													<div class="d-flex align-items-center gap-3">
														<div>
															<label for="file-input" style="cursor: pointer;">
																<img id="camera-icon" 
																	src="{{ asset('img/camera-icon.jpg') }}" 
																	style="width: 80px; transition: opacity 0.3s ease, transform 0.3s ease;" 
																	onclick="getLocation()" 
																	alt="Camera Icon">
															</label>
															<input 
																style="opacity: 0; position: absolute; width: 1px; height: 1px;" 
																capture 
																id="file-input" 
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
												</div>

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

							
								
								
								

								
								

								

								
								
			
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
@section('js')

<script>
function loadProducts(sort = 'newest', page = 1, search = '') {
    const apiUrl = `{{ url('/api/kunjungan') }}?sort=${sort}&page=${page}&search=${encodeURIComponent(search)}`;
    //console.log(apiUrl);
    
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const kunjunganContainer = document.querySelector(".top-products-area .container .row");
            kunjunganContainer.innerHTML = "";

            if (data.data.length > 0) {
                data.data.forEach(kunjungan => {
                    const assetPath = "{{ asset('img/kunjungan/') }}";
                    const urlPath = "{{ url('/kunjungan/') }}";

                    kunjunganContainer.innerHTML += `
                        <div class="col-12">
                            <div class="card single-product-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        

                                        <!-- Konten -->
                                        <div class="card-content px-4 py-2">
                                            <a class="product-title d-block text-truncate mt-0" href="${urlPath}/${kunjungan.id}/edit">
                                                ${kunjungan.nama_customer}
                                                <br/>
                                                ${kunjungan.alamat}
                                                <br/>
                                                ${formatTanggal(kunjungan.tgl_mulai)} s.d ${formatTanggal(kunjungan.tgl_selesai)} 
                                                <br/>
                                               Catatan : ${kunjungan.catatan ? kunjungan.catatan : ''}
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
	function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
				// var mapSrc = `https://maps.google.com/maps?q=${position.coords.latitude},${position.coords.longitude}&output=embed`;
				// document.getElementById("embedMaps").src = mapSrc;
            }, function(error) {
                console.error("Error mendapatkan lokasi: ", error);
                alert("Gagal mendapatkan lokasi. Pastikan GPS diaktifkan.");
            });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }
    }
    var loadFile = function(event) {
        var cameraIcon = document.getElementById('camera-icon');

        // Kasih efek fade-out dulu
        cameraIcon.style.opacity = 0;
        cameraIcon.style.transform = 'scale(0.95)';

        // Setelah beberapa milidetik (tunggu animasi), baru ganti src
        setTimeout(function() {
            cameraIcon.src = URL.createObjectURL(event.target.files[0]);
            cameraIcon.onload = function() {
                // Setelah gambar baru selesai load, fade-in
                cameraIcon.style.opacity = 1;
                cameraIcon.style.transform = 'scale(1)';
            };
        }, 300); // 300ms sama kayak durasi transition
    };

	    document.addEventListener("DOMContentLoaded", function () {
        loadProducts();

        document.getElementById("defaultSelectSm").addEventListener("change", function () {
            loadProducts(this.value);
        });
    });



</script>
@endsection
@endsection