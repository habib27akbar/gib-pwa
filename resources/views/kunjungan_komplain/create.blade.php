@extends('layouts.master')
@section('title','Kunjungan')
@section('content')

        <div class="page-content-wrapper py-3">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="mb-3">Laporan Kunjungan Komplain</h5>
						<div class="contact-form">
							<form id="kunjunganForm" action="{{ route('kunjungan_komplain.store') }}" method="post" enctype="multipart/form-data">
								@csrf
                                <input type="hidden" name="teknisi" value="true">
                                <input type="hidden" name="id_komplain" value="{{ request()->get('id_kunjungan') }}">
                                <input type="hidden" name="id_unit" value="{{ request()->get('id_unit') }}">
                                <input type="hidden" name="id_customer" value="{{ request()->get('id_customer') }}">
                                <input type="hidden" name="id_lokasi" value="{{ request()->get('id_lokasi') }}">
                                <div class="form-group">
                        
                                   <label class="form-label" style="color: black">Tanggal</label>
                                   <input type="date" name="tanggal" class="form-control" value="{{ $laporan?$laporan->tanggal:date('Y-m-d') }}">
                                </div>

                                <div class="form-group">
                        
                                   <label class="form-label" style="color: black">Gambar/File</label>
                                   <input type="file" name="gambar" class="form-control">
                                   <input type="hidden" name="gambar_old" value="{{ $laporan?$laporan->gambar:null }}">
                                   @if ($laporan)
                                        @if ($laporan->gambar)
                                            <a href="{{ url('public/img/kunjungan/'.$laporan->gambar) }}" target="_blank" rel="noopener noreferrer">File</a>
                                        @endif
                                       
                                   @endif
                                   
                                </div>

                                

                                
                                    <input type="hidden" name="gambar_old">
                                    <input type="hidden" id="latitude" name="latitude" readonly>
                                    <input type="hidden" id="longitude" name="longitude" readonly>
                                </div>

                                <div class="form-group">
                        
                                    <label class="form-label" style="color: black">Catatan</label>
                                    <input type="text" class="form-control" name="catatan" required value="{{ $laporan ? $laporan->catatan :'' }}">
                                    
                                </div>
								<button type="submit" class="btn btn-primary w-100">Simpan</button>
							</form>
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
@endsection