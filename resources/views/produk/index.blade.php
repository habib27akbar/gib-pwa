@extends('layouts.master')
@section('title','Produk')
@section('css')

  <style>
    /* Warna emas/gold untuk bintang */
    .fa-star {
    color: gold; /* Atau bisa pakai hex #FFD700 */
    }

    .fa-star-o {
    color: #ccc; /* Warna bintang tidak aktif */
    }
  </style>
@endsection
@section('content')

        <div class="page-content-wrapper py-3">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						
						<div class="contact-form">
							
								<div class="form-group mb-3">
									<select name="id_lokasi" id="id_lokasi" onchange="pilihLokasi(this.value)" class="form-control" required>
										<option value="">-- Pilih Lokasi --</option>
									</select>
								</div>

								<!-- Container produk -->
                                <div id="produkContainer" class="row">
                                    <!-- Produk akan ditampilkan di sini -->
                                </div>

								
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade" id="ulasanModal" tabindex="-1" aria-labelledby="modalPeriodeLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               
                
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPeriodeLabel">Berikan Ulasan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                           
                           <input type="hidden" name="id_customer" id="id_customer">
                           <input type="hidden" name="id_produk" id="id_produk">
                           <input type="hidden" name="id_ulasan" id="id_ulasan">
                           <input type="hidden" name="id_lokasi" id="id_lokasi_modal">
                           <input type="hidden" name="id" id="id">
                            <center>
                                <label class="form-label d-block mb-2">Beri Penilaian</label>
                                <div id="star-rating">
                                    <input type="hidden" name="rating" id="rating" value="0">
                                    <i class="fa fa-star-o fa-2x" data-value="1"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="2"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="3"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="4"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="5"></i>
                                </div>
                            </center>
                            <br/>
                            <input type="text" name="ulasan_produk" id="ulasan_produk" class="form-control" placeholder="Berikan Ulasan Anda" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" id="btnKirimUlasan" class="btn btn-primary">Simpan</button>
                        </div>

                    </div>
               
            </div>
        </div>

        <div class="modal fade" id="lihatUlasan" tabindex="-1" aria-labelledby="modalPeriodeLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               
                
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPeriodeLabel">Lihat Ulasan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                           
                           <input type="hidden" name="id_customer" id="id_customer_ulasan">
                           <input type="hidden" name="id_produk" id="id_produk_ulasan">
                           <input type="hidden" name="id_ulasan" id="id_ulasan_ulasan">
                           <input type="hidden" name="id_lokasi" id="id_lokasi_modal_ulasan">
                           <input type="hidden" name="id" id="id">
                            <center>
                                {{-- <label class="form-label d-block mb-2">Beri Penilaian</label> --}}
                                <div id="star-rating-ulasan">
                                    <input type="hidden" name="rating_ulasan" id="rating_ulasan" value="0">
                                    <i class="fa fa-star-o fa-2x" data-value="1"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="2"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="3"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="4"></i>
                                    <i class="fa fa-star-o fa-2x" data-value="5"></i>
                                </div>
                            </center>
                            <br/>
                            <input type="text" name="ulasan_produk" id="ulasan_produk_ulasan" class="form-control" placeholder="Berikan Ulasan Anda" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           
                        </div>

                    </div>
               
            </div>
        </div>
@section('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const stars = document.querySelectorAll('#star-rating .fa');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function () {
        const rating = this.getAttribute('data-value');
        ratingInput.value = rating;

        // Reset semua bintang
        stars.forEach(s => s.classList.remove('fa-star'));
        stars.forEach(s => s.classList.add('fa-star-o'));

        // Aktifkan bintang sampai yang diklik
        for (let i = 0; i < rating; i++) {
            stars[i].classList.remove('fa-star-o');
            stars[i].classList.add('fa-star');
        }
        });
    });

    function loadFile(event) {
        const output = document.getElementById("preview");
        output.style.display = "block";
        output.src = URL.createObjectURL(event.target.files[0]);
        document.getElementById("error-message").style.display = "none"; // Sembunyikan pesan error jika file dipilih
    }

	function loadFileGaleri(event) {
        const output = document.getElementById("preview_galeri");
        output.style.display = "block";
        output.src = URL.createObjectURL(event.target.files[0]);
        
    }

	$(document).ready(function() {
        $.ajax({
            url: "{{ route('get.lokasi') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
				console.log(data);
				
                let select = $('#id_lokasi');
                select.empty();
                select.append('<option value="">--Pilih Lokasi--</option>'); // Opsi default

                $.each(data, function(index, lokasi) {
                    
                        select.append('<option value="' + lokasi.id + '">' + lokasi.alamat + '</option>');
                    
                });

                select.trigger("chosen:updated"); // Jika pakai Chosen.js
            },
            error: function(xhr) {
                console.log("Error: " + xhr.responseText);
            }
        });

        
    });

    

	function pilihLokasi(idLokasi) {
        const container = document.getElementById('produkContainer');
        container.innerHTML = ''; // Kosongkan kontainer dulu
        const assetPath = "https://ptgib.co.id/asset/img_produk/";
        
        if (idLokasi !== '') {
            fetch(`/get-produk-with-unit-customer/${idLokasi}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(item => {
                            // Loop unit
                            let unitHTML = '';
                            if (item.units && item.units.length > 0) {
                                unitHTML += '<table class="table stripted-table">';
                                unitHTML += '<tr><th>Serial Number</th><th>Tgl. Pembelian</th>';
                                console.log(item.units);
                                
                                item.units.forEach(unit => {
                                    unitHTML += `<tr><td>${unit.serial_number}</td> <td>${formatTanggal(unit.tgl_pembelian)}</td></tr>`;
                                });
                                unitHTML += '</table>';
                            } else {
                                unitHTML = '<p class="text-muted">Tidak ada unit tersedia.</p>';
                            }
                            let starsHtmlData = '';
                            const ratingData = item.bintang;
                            for (let i = 0; i < 5; i++) {
                                if (i < ratingData) {
                                    starsHtmlData += '<span style="color: gold;">&#9733;</span>'; // ★
                                } else {
                                    starsHtmlData += '<span style="color: lightgray;">&#9733;</span>'; // ☆
                                }
                            }

                            const produkCard = `
                                <div class="col-md-12 mb-4">
                                    <div class="card h-100">
                                        <img src="${assetPath}${item.gambar}" class="card-img-top" alt="${item.judul}" style="object-fit: cover;">
                                        
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                ${item.judul} <div id="star-rating-cs${item.id}">${starsHtmlData}</div>
                                                ${item.status == 1 ? `
                                                    <a class="btn-sm btn-success btn-lihat-ulasan" data-id="${item.id}" data-id_customer="${item.id_customer_item}" data-produk="${item.id_produk}" data-ulasan="${item.id_ulasan}" data-lokasi="${item.id_lokasi}">
                                                        Lihat Ulasan
                                                    </a>
                                                ` : `
                                                    <a class="btn-sm btn-success btn-ulasan" data-id="${item.id}" data-id_customer="${item.id_customer_item}" data-produk="${item.id_produk}" data-ulasan="${item.id_ulasan}" data-lokasi="${item.id_lokasi}">
                                                        Berikan Ulasan
                                                    </a>
                                                `}
                                                
                                            </h5>
                                            <div>${item.isi_produk}</div>
                                            <h6 class="mt-3">Unit Tersedia:</h6>
                                            ${unitHTML}
                                        </div>
                                    </div>
                                </div>
                            `;
                            container.innerHTML += produkCard;
                        });
                    } else {
                        container.innerHTML = '<div class="col-12"><p class="text-center">Tidak ada produk di lokasi ini.</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Gagal ambil data produk:', error);
                    container.innerHTML = '<div class="col-12"><p class="text-danger text-center">Gagal mengambil data produk.</p></div>';
                });
        }
    }

    //$(document).ready(pilihLokasi);
    
    $(document).on('click', '.btn-ulasan', function(e) {
        e.preventDefault();

        // Ambil data dari tombol
        const id = $(this).data('id');
        const id_produk = $(this).data('produk');
        const id_ulasan = $(this).data('ulasan');
        const id_customer = $(this).data('id_customer');
        const id_lokasi = $(this).data('lokasi');
        //console.log(id_lokasi);
        

        // Push ke modal
        $('#id_produk').val(id_produk);
        $('#id_customer').val(id_customer);
        $('#id_ulasan').val(id_ulasan);
        $('#id_lokasi_modal').val(id_lokasi);
        $('#id').val(id);
        const namaProduk = document.getElementById('modalPeriodeLabel');
        namaProduk.innerHTML = ''; // Kosongkan kontainer dulu

         fetch(`/get-produk/${id_produk}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    //console.log(data);
                    namaProduk.innerHTML = data[0].judul;
                } else {
                    //container.innerHTML = '<div class="col-12"><p class="text-center">Tidak ada produk di lokasi ini.</p></div>';
                }
            })
            .catch(error => {
                console.error('Gagal ambil data produk:', error);
                //container.innerHTML = '<div class="col-12"><p class="text-danger text-center">Gagal mengambil data produk.</p></div>';
            });

        fetch(`/get-ulasan/${id_customer}/${id_produk}/${id_lokasi}`)
            .then(response => response.json())
            .then(data => {
                const stars = document.querySelectorAll('#star-rating .fa');
                stars.forEach(s => s.classList.remove('fa-star'));
                stars.forEach(s => s.classList.add('fa-star-o'));
                if (data.length > 0) {
                    //console.log(data);
                    //namaProduk.innerHTML = data[0].judul;
                    
                    const ratingData = parseInt(data[0].bintang);
                    const ulasanData = data[0].ulasan;

                    
                    
                    const ratingInput = document.getElementById('rating');

                    stars.forEach(star => {
                        
                        const rating = ratingData;
                        ratingInput.value = rating;

                        // Reset semua bintang
                        // stars.forEach(s => s.classList.remove('fa-star'));
                        // stars.forEach(s => s.classList.add('fa-star-o'));

                        // Aktifkan bintang sampai yang diklik
                        for (let i = 0; i < rating; i++) {
                            stars[i].classList.remove('fa-star-o');
                            stars[i].classList.add('fa-star');
                        }
                       
                    });
                    
                    $('#rating').val(ratingData);
                    $('#ulasan_produk').val(data[0].ulasan);
                } else {
                    $('#rating').val(0);
                    $('#ulasan_produk').val(null);
                    //container.innerHTML = '<div class="col-12"><p class="text-center">Tidak ada produk di lokasi ini.</p></div>';
                }
            })
            .catch(error => {
                console.error('Gagal ambil data produk:', error);
                //container.innerHTML = '<div class="col-12"><p class="text-danger text-center">Gagal mengambil data produk.</p></div>';
            });

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('ulasanModal'));
        modal.show();
    });

    $(document).on('click', '.btn-lihat-ulasan', function(e) {
        e.preventDefault();

        // Ambil data dari tombol
        const id = $(this).data('id');
        const id_produk = $(this).data('produk');
        const id_ulasan = $(this).data('ulasan');
        const id_customer = $(this).data('id_customer');
        const id_lokasi = $(this).data('lokasi');
        //console.log(id_lokasi);
        

        // Push ke modal
        $('#id_produk').val(id_produk);
        $('#id_customer').val(id_customer);
        $('#id_ulasan').val(id_ulasan);
        $('#id_lokasi_modal').val(id_lokasi);
        $('#id').val(id);
        const namaProduk = document.getElementById('modalPeriodeLabel');
        namaProduk.innerHTML = ''; // Kosongkan kontainer dulu

         fetch(`/get-produk/${id_produk}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    //console.log(data);
                    namaProduk.innerHTML = data[0].judul;
                } else {
                    //container.innerHTML = '<div class="col-12"><p class="text-center">Tidak ada produk di lokasi ini.</p></div>';
                }
            })
            .catch(error => {
                console.error('Gagal ambil data produk:', error);
                //container.innerHTML = '<div class="col-12"><p class="text-danger text-center">Gagal mengambil data produk.</p></div>';
            });

        fetch(`/get-ulasan/${id_customer}/${id_produk}/${id_lokasi}`)
            .then(response => response.json())
            .then(data => {
                const stars = document.querySelectorAll('#star-rating-ulasan .fa');
                stars.forEach(s => s.classList.remove('fa-star'));
                stars.forEach(s => s.classList.add('fa-star-o'));
                if (data.length > 0) {
                    //console.log(data);
                    //namaProduk.innerHTML = data[0].judul;
                    
                    const ratingData = parseInt(data[0].bintang);
                    const ulasanData = data[0].ulasan;

                    
                    
                    const ratingInput = document.getElementById('rating');

                    stars.forEach(star => {
                        
                        const rating = ratingData;
                        ratingInput.value = rating;

                        // Reset semua bintang
                        // stars.forEach(s => s.classList.remove('fa-star'));
                        // stars.forEach(s => s.classList.add('fa-star-o'));

                        // Aktifkan bintang sampai yang diklik
                        for (let i = 0; i < rating; i++) {
                            stars[i].classList.remove('fa-star-o');
                            stars[i].classList.add('fa-star');
                        }
                       
                    });
                    
                    $('#rating_ulasan').val(ratingData);
                    $('#ulasan_produk_ulasan').val(data[0].ulasan);
                } else {
                    $('#rating').val(0);
                    $('#ulasan_produk').val(null);
                    //container.innerHTML = '<div class="col-12"><p class="text-center">Tidak ada produk di lokasi ini.</p></div>';
                }
            })
            .catch(error => {
                console.error('Gagal ambil data produk:', error);
                //container.innerHTML = '<div class="col-12"><p class="text-danger text-center">Gagal mengambil data produk.</p></div>';
            });

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('lihatUlasan'));
        modal.show();
    });


	function pilihProduk(idItem) {
        const produkSelect = document.getElementById('id_unit');
        produkSelect.innerHTML = '<option value="">-- Memuat Unit... --</option>';

        fetch("{{ url('/get-unit-customer') }}/" + idItem)
            .then(response => response.json())
            .then(data => {
                produkSelect.innerHTML = '<option value="">-- Pilih Unit --</option>';

                if (data.length > 0) {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.serial_number+' tgl. pembelian : '+formatTanggal(item.tgl_pembelian);
                        produkSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Unit tidak ditemukan';
                    produkSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Gagal mengambil produk:', error);
                produkSelect.innerHTML = '<option value="">Gagal memuat unit</option>';
            });
    }

$('#btnKirimUlasan').click(function () {
  const id_produk = $('#id_produk').val();
  const id_customer = $('#id_customer').val();
  const id_ulasan = $('#id_ulasan').val();
  const ulasan_produk = $('#ulasan_produk').val();
  const rating = $('#rating').val();
  const id_lokasi = $('#id_lokasi').val();
  const id = $('#id').val();
  //console.log($('meta[name="csrf-token"]').attr('content'));
  if (!rating || parseInt(rating) === 0) {
    alert('Silakan beri rating terlebih dahulu.');
    return;
  }

  if (!ulasan_produk) {
    alert('Silakan isi ulasan terlebih dahulu.');
    return;
  }
  $.ajax({
    url: '/produk/ulasan', // route Laravel
    type: 'POST',
    data: {
      id_produk: id_produk,
      id_customer: id_customer,
      id_ulasan: id_ulasan,
      id_lokasi: id_lokasi,
      rating: rating,
      ulasan_produk:ulasan_produk
     
    },
    success: function (response) {
        //console.log(response);
        
     if (response == 'ok') {
        //const rating = parseInt($('#rating').val()); // pastikan angka
        let starsHtml = '';

        // Buat bintang aktif
        for (let i = 0; i < 5; i++) {
            if (i < rating) {
                starsHtml += '<span style="color: gold;">&#9733;</span>'; // ★
            } else {
                starsHtml += '<span style="color: lightgray;">&#9733;</span>'; // ☆
            }
        }
        console.log(id);
        
        $('#star-rating-cs'+id).html(starsHtml);
        $('#ulasanModal').modal('hide');
     }
      
      //console.log(response);
      // Update bagian produk langsung tanpa reload
      //$(`#produk-${id}`).append(`<p><strong>Ulasan:</strong> ${ulasan}</p>`);
    }
  });
});
function formatTanggal(tgl) {
    const date = new Date(tgl);
    const pad = n => n.toString().padStart(2, '0');
    const shortYear = date.getFullYear().toString().slice(-2); // ambil dua digit terakhir
    return `${pad(date.getDate())}/${pad(date.getMonth() + 1)}/${shortYear}`;
}
</script>
@endsection
@endsection