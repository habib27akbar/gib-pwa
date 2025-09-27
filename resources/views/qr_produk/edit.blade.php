@extends($layout)
@section('title','Detail Produk')
@section('content')

        <div class="py-5" style="padding-top:4rem !important;">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="mb-3">Detail Produk</h5>
						<div class="contact-form">
							<div class="col-md-12 mb-4">
                                    @php
                                        $gambar = $produk->gambar;
                                        $daftarGambar = explode(";", $gambar); // pisahkan string menjadi array    
                                    @endphp
                                    <img src="https://ptgib.co.id/asset/img_produk/{{ $daftarGambar[0] }}" class="card-img-top" alt="{{ $produk->judul }}" style="object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $produk->judul }}</h5>
                                        <div><?=$produk->isi_produk?></div>
                                        @if (Auth::check())
                                            @if (
                                                //false
                                                !empty($data_unit)
                                            )
                                                @foreach ($data_unit as $lokasi)
                                                   
                                                    <div id="detailContent">
                                                    
                                                            <table class="table stripted-table">
                                                                <tr>
                                                                    <td colspan="2" style="text-align: center">
                                                                        Lokasi : {{ $lokasi['alamat'] }}
                                                                            <br/>
                                                                            (QR Code : {{ $param }})
                                                                        
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                   
                                                                    <td>Keterangan</td>
                                                                </tr> --}}
                                                            @if ($lokasi['unit']->isNotEmpty())
                                                                
                                                            
                                                                @foreach ($lokasi['unit'] as $item)
                                                                
                                                                    @if ($item->serial_number == $param)
                                                                        
                                                                   
                                                                        <tr>
                                                                           
                                                                            <td>
                                                                                <?=$item->keterangan?>

                                                                                @if($item->tgl_pembelian)
                                                                                
                                                                                   Tgl. Pembelian : {{ \Carbon\Carbon::parse($item->tgl_pembelian)->format('d/m/y') }}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <center>
                                                                                    <a href="{{ route('history.show', ['id_produk' => $produk->id_produk, 'id_lokasi' => $lokasi['id_lokasi']]) }}?param={{ $param }}&id_unit={{ $item->id_unit }}" class="btn btn-primary">Lihat riwayat kunjungan</a>
                                                                                </center>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <center>
                                                                                    <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">
                                                                                        Ajukan Komplain
                                                                                    </a>
                                                                                </center>
                                                                                

                                                                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                                        <div class="modal-content">

                                                                                        <!-- Header -->
                                                                                        <div class="modal-header">
                                                                                           
                                                                                            <h4 class="modal-title" id="myModalLabel">Komplain</h4>
                                                                                        </div>
                                                                                        <form id="komplainForm" action="{{ route('komplain.store') }}" method="post" enctype="multipart/form-data">
								                                                            @csrf
                                                                                            <!-- Body -->
                                                                                                <div class="modal-body">
                                                                                                    <input type="hidden" name="id_lokasi" id="id_lokasi" value="{{ $id_lokasi }}">
                                                                                                    <input type="hidden" name="id_unit" id="id_unit" value="{{ $item->id_unit }}">
                                                                                                    <input type="hidden" name="id_customer" id="id_customer" value="{{ $item->id_customer }}">
                                                                                                    <input type="hidden" name="id_produk" id="id_produk" value="{{ $item->id_produk }}">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="file-input">
                                                                                                            <img src="{{ asset('img/camera-icon.jpg') }}" style="width: 35%" alt="Camera Icon">
                                                                                                        </label>
                                                                                                        <input style="opacity: 0; position: absolute; width: 1px; height: 1px;" id="file-input" class="form-control" type="file" name="gambar" accept="image/*" onchange="loadFile(event)">
                                                                                                        <img id="preview" style="display: none; max-width: 100px; margin-top: 10px;" />
                                                                                                        
                                                                                                    </div>
                                                                                                    <div class="form-group mb-3">
                                                                                                        <textarea class="form-control" name="pesan" cols="30" rows="10" placeholder="pesan" required></textarea>
                                                                                                    </div>
                                                                                                </div>

                                                                                            <!-- Footer -->
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tutup</button>
                                                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                                            </div>
                                                                                        </form>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif   
                                                                
                                                                
                                                            </table>
                                                        
                                                        
                                                    </div>
                                                @endforeach
                                            @endif
                                            
                                        @endif
                                        {{-- @if (Auth::user()->id)
                                            
                                        @endif --}}
                                        
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

    document.getElementById('toggleButton').addEventListener('click', function() {
        var content = document.getElementById('detailContent');
        var button = document.getElementById('toggleButton');
        
        if (content.style.display === "none") {
            content.style.display = "block";
            button.innerHTML = 'Tutup Detail Unit <i class="fa fa-arrow-up" aria-hidden="true"></i>';
        } else {
            content.style.display = "none";
            button.innerHTML = 'Lihat Detail Unit <i class="fa fa-arrow-down" aria-hidden="true"></i>';
        }
    });                                       

</script>
@endsection
@endsection