@extends('layouts.master')
@section('title','Absensi')
@section('css')
<style>
#cameraPreview:hover {
    border-color: #0d6efd;
    transform: scale(1.02);
}
#cameraPreview:hover #cameraIcon {
    opacity: 1;
    transform: scale(1.1);
}
.loading-overlay{
    position:fixed; inset:0;
    background:rgba(255,255,255,.85);
    display:none; align-items:center; justify-content:center;
    z-index:1055;
  }
</style>
@endsection
@section('content')
<div id="loadingOverlay" class="loading-overlay">
  <div class="text-center">
    <div class="spinner-border mb-3" role="status" aria-hidden="true"></div>
    <div>Mengunggah… mohon tunggu</div>
  </div>
</div>
        <div class="page-content-wrapper py-3">
			<div class="container">
				<!-- Contact Form -->
				<div class="card mb-3">
					<div class="card-body">
						
						<div class="contact-form">
							<form id="absenForm" action="{{ route('absen.store') }}" method="post" enctype="multipart/form-data" class="text-center">
                                @csrf
                                
                                <input type="hidden" name="latitude">
                                <input type="hidden" name="longitude">
                                
                                
                                <div class="mb-4">
                                    <!-- Camera Preview Area -->
                                    <div id="cameraPreview" class="mx-auto mb-3" style="width: 250px; height: 250px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <img id="cameraIcon" src="{{ asset('img/camera-icon.jpg') }}" class="img-fluid" style="max-width: 80px; opacity: 0.7; transition: all 0.3s ease;">
                                    </div>
                                    
                                    <!-- Actual File Input (hidden) -->
                                    <input type="file" id="selfieInput" name="image" accept="image/*" capture="user" style="display: none;">
                                    
                                    <div class="text-muted">
                                        <h5 class="mb-1">Ambil Selfie</h5>
                                        <small>Klik pada area kamera di atas</small>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 25px;">
                                    <i class="fa fa-save me-2"></i> Simpan Absensi
                                </button>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const cameraPreview = document.getElementById('cameraPreview');
  const selfieInput    = document.getElementById('selfieInput');
  const cameraIcon     = document.getElementById('cameraIcon');

  const form       = document.getElementById('absenForm');
  const overlay    = document.getElementById('loadingOverlay');
  const submitBtn  = form ? form.querySelector('button[type="submit"]') : null;

  // ==== klik area kamera ====
  cameraPreview.addEventListener('click', function() {
    selfieInput.click();
  });

  // ==== preview foto ====
  selfieInput.addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
      const reader = new FileReader();
      reader.onload = function(event) {
        cameraPreview.style.backgroundImage = `url(${event.target.result})`;
        cameraPreview.style.backgroundSize = 'cover';
        cameraPreview.style.backgroundPosition = 'center';
        cameraIcon.style.opacity = '0';
      }
      reader.readAsDataURL(e.target.files[0]);
    }
  });

  // ==== geolokasi ====
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      document.querySelector('input[name="latitude"]').value  = position.coords.latitude;
      document.querySelector('input[name="longitude"]').value = position.coords.longitude;
    });
  }

  // ==== tampilkan loading hanya saat submit ====
  let isSubmitting = false;
  if (form) {
    form.addEventListener('submit', function (e) {
      if (isSubmitting) return;          // cegah double submit
      isSubmitting = true;

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML =
          '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mengunggah…';
      }
      if (overlay) overlay.style.display = 'flex';
    });
  }
});
</script>
@endsection
@endsection