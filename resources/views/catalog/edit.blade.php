@extends('layouts.master')
@section('title','Catalog Detail')
@section('content')

        <div class="page-content-wrapper py-3">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="mb-3">Catalog Detail</h5>
						<div class="contact-form">
							<div class="col-md-12 mb-4">
                                
                                    <img src="https://ptgib.co.id/asset/img_produk/{{ $produk->gambar }}" class="card-img-top" alt="${item.judul}" style="object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $produk->judul }}</h5>
                                        <div><?=$produk->isi_produk?></div>
                                        
                                    </div>
                                
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
@section('js')
<script>
    

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
				//console.log(data);
				
                let select = $('#id_lokasi');
                select.empty();
                select.append('<option value="">--Pilih Lokasi--</option>'); // Opsi default
				let selectedLokasiId = "{{ $komplain->id_lokasi ?? '' }}";

                $.each(data, function(index, lokasi) {
                    let selected = lokasi.id == selectedLokasiId ? 'selected' : '';
                    select.append('<option value="' + lokasi.id + '" ' + selected + '>' + lokasi.alamat + '</option>');
                    
                });

                select.trigger("chosen:updated"); // Jika pakai Chosen.js
            },
            error: function(xhr) {
                console.log("Error: " + xhr.responseText);
            }
        });

        
    });

	function pilihLokasi(idLokasi) {
        const produkSelect = document.getElementById('id_item');
        produkSelect.innerHTML = '<option value="">-- Memuat Produk... --</option>';

        fetch("{{ url('/get-produk-customer') }}/" + idLokasi)
            .then(response => response.json())
            .then(data => {
                produkSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';

                if (data.length > 0) {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.judul;
                        produkSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Produk tidak ditemukan';
                    produkSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Gagal mengambil produk:', error);
                produkSelect.innerHTML = '<option value="">Gagal memuat produk</option>';
            });
    }

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

function formatTanggal(tgl) {
    const date = new Date(tgl);
    const pad = n => n.toString().padStart(2, '0');
    const shortYear = date.getFullYear().toString().slice(-2); // ambil dua digit terakhir
    return `${pad(date.getDate())}/${pad(date.getMonth() + 1)}/${shortYear}`;
}
</script>
@endsection
@endsection