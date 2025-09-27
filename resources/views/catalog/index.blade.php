@extends('layouts.master')
@section('title','User')
@section('content')

        <div class="page-content-wrapper py-3">
            @include('include.admin.alert')
			<!-- Pagination-->
			<div class="shop-pagination pb-3">
				<div class="container">
					
                    <div class="d-flex align-items-center justify-content-between">
                        {{-- <a href="{{ route('catalog.create') }}" class="btn btn-primary">Tambah</a> --}}
                         <input type="text" id="search-input" class="form-control" placeholder="Cari catalog..." style="max-width: 300px;">
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
    const apiUrl = `{{ url('/api/catalog') }}?sort=${sort}&page=${page}&search=${encodeURIComponent(search)}`;
    //console.log(apiUrl);
    
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const catalogContainer = document.querySelector(".top-products-area .container .row");
            catalogContainer.innerHTML = "";

            if (data.data.length > 0) {
                data.data.forEach(catalog => {
                    const assetPath = "https://ptgib.co.id/asset/img_produk/";
                    const urlPath = "{{ url('/catalog/') }}";

                    catalogContainer.innerHTML += `
                        <div class="col-12">
                            <div class="card single-product-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <!-- Gambar catalog (Kiri & Kanan) -->
                                        <div class="card-side-img d-flex">
                                            <!-- Gambar Utama -->
                                            ${catalog.gambar ? `
                                                <a class="product-thumbnail d-block me-2" href="${urlPath}/${catalog.id_produk}/edit">
                                                    <img src="${assetPath}/${catalog.gambar}">
                                                </a>
                                            ` : ''}

                                           
                                        </div>

                                        <!-- Konten -->
                                        <div class="card-content px-4 py-2">
                                            <a style="font-size:13px" href="${urlPath}/${catalog.id_produk}/edit">
                                                ${catalog.judul}
                                                
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
</script>
@endsection  

@endsection