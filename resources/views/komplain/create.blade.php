@extends('layouts.master')
@section('title','Komplain')
@section('content')

        <div class="page-content-wrapper py-3">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="mb-3">Formulir Komplain (Tambah)</h5>
						<div class="contact-form">
							<form id="komplainForm" action="{{ route('komplain.store') }}" method="post" enctype="multipart/form-data">
								@csrf
<<<<<<< HEAD

								<div class="form-group mb-3">
									<select name="id_lokasi" id="id_lokasi" onchange="pilihLokasi(this.value)" class="form-control" required>
										<option value="">-- Pilih Lokasi --</option>
									</select>
								</div>

								<div class="form-group mb-3">
									<select name="id_item" id="id_item" onchange="pilihProduk(this.value)" class="form-control" required>

                                    </select>
								</div>

								<div class="form-group mb-3">
									<select name="id_unit" id="id_unit" class="form-control" required>

                                    </select>
								</div>

								<div class="form-group mb-3">
									<label for="file-input">
										<img src="{{ asset('img/camera-icon.jpg') }}" style="width: 35%" alt="Camera Icon">
									</label>
									<input style="opacity: 0; position: absolute; width: 1px; height: 1px;" id="file-input" class="form-control" type="file" name="gambar" accept="image/*" onchange="loadFile(event)">
=======

								<div class="form-group mb-3">
									<label for="file-input">
										<img src="{{ asset('img/camera-icon.jpg') }}" style="width: 35%" alt="Camera Icon">
									</label>
									<input style="opacity: 0; position: absolute; width: 1px; height: 1px;" id="file-input" class="form-control" type="file" name="gambar" accept="image/*" onchange="loadFile(event)" required>
>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e
									<img id="preview" style="display: none; max-width: 100px; margin-top: 10px;" />
									
								</div>

<<<<<<< HEAD
								
=======
								<div class="form-group mb-3">
									
									<label for="file-input-galeri">
										<img src="{{ asset('img/1375106.png') }}" style="width: 14%" alt="Camera Icon">
									</label>
									<input style="opacity: 0; position: absolute; width: 1px; height: 1px;" id="file-input-galeri" class="form-control" type="file" name="gambar_galeri" accept="image/*" onchange="loadFileGaleri(event)">
									<img id="preview_galeri" style="display: none; max-width: 100px; margin-top: 10px;" />
									
									
									
								</div>
>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e

								<div class="form-group mb-3">
									<textarea class="form-control" name="pesan" cols="30" rows="10" placeholder="pesan" required></textarea>
								</div>
								<button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
							</form>
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
<<<<<<< HEAD

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
                        option.textContent = item.keterangan.replace(/<[^>]*>/g, '');;
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
=======

	function loadFileGaleri(event) {
        const output = document.getElementById("preview_galeri");
        output.style.display = "block";
        output.src = URL.createObjectURL(event.target.files[0]);
        
    }
>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e
</script>
@endsection
@endsection