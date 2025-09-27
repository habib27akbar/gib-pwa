@extends('layouts.master')
@section('title','Kunjungan Teknisi')
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

					<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPeriode">
						+ Tambah Kunjungan
					</button>

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

		</div>
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        loadProducts();

        document.getElementById("defaultSelectSm").addEventListener("change", function () {
            loadProducts(this.value);
        });
    });


function loadProducts(sort = 'newest', page = 1, search = '') {
    const apiUrl = `{{ url('/api/kunjungan_teknisi') }}?sort=${sort}&page=${page}&search=${encodeURIComponent(search)}`;
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
                                                <a class="product-thumbnail d-block me-2" data-bs-toggle="modal" data-bs-target="#editData${idData}">
                                                    <img src="${assetPath}/${kunjungan.gambar}">
                                                </a>
                                            ` : ''}

                                           
                                        </div>

                                        <!-- Konten -->
                                        <div class="card-content px-4 py-2">
                                            <a class="product-title d-block text-truncate mt-0" data-bs-toggle="modal" data-bs-target="#editData${idData}">
                                               ${kunjungan.tanggal}
												<br/>
                                               Catatan : ${kunjungan.catatan ? kunjungan.catatan : ''}
                                            </a>
                                            
                                            
                                            
                                        </div>

										<div class="modal fade" id="editData${idData}" tabindex="-1" aria-labelledby="editDataLabel${idData}" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<form action="/kunjungan/${idData}" method="POST" enctype="multipart/form-data">
														<input type="hidden" name="_method" value="PUT"> <!-- karena form update -->
														<input type="hidden" name="_token" value="{{ csrf_token() }}"> <!-- penting untuk laravel -->

														<div class="modal-header">
															<h5 class="modal-title" id="editDataLabel${idData}">Edit Kunjungan</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
														</div>

														<div class="modal-body">
															<div class="mb-3">
																<label class="form-label">Tanggal</label>
																<input type="date" class="form-control" name="tanggal" value="${kunjungan.tanggal_db_format}">
															</div>
															<div class="mb-3">
																<label class="form-label">Catatan</label>
																<textarea class="form-control" name="catatan" rows="3">${kunjungan.catatan || ''}</textarea>
															</div>
															<div class="mb-3">
																<label class="form-label">Upload Gambar</label>
																<input type="file" class="form-control" name="gambar">
															</div>
														</div>

														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
															<button type="submit" class="btn btn-primary">Simpan</button>
														</div>
													</form>
												</div>
											</div>
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
</script>
@endsection  

@endsection