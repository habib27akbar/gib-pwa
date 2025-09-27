@extends('layouts.master')
@section('title','Komplain')
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
						{{-- <h5 class="mb-3">Penilaian</h5> --}}
						<div class="contact-form">
							<form action="{{ route('penilaian.update', ['penilaian' => $kunjungan->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group text-center mb-3">
                                    <p style="text-align: justify">{{ $kunjungan->pesan }}</p>
                                    <label class="form-label d-block mb-2">Beri Penilaian</label>
                                    <div id="star-rating">
                                        <input type="hidden" name="rating" id="rating" value="0">
                                        <i class="fa fa-star-o fa-2x" data-value="1"></i>
                                        <i class="fa fa-star-o fa-2x" data-value="2"></i>
                                        <i class="fa fa-star-o fa-2x" data-value="3"></i>
                                        <i class="fa fa-star-o fa-2x" data-value="4"></i>
                                        <i class="fa fa-star-o fa-2x" data-value="5"></i>
                                    </div>
                                </div>
                                <input type="text" name="catatan" class="form-control" placeholder="Terima Kasih !">
                                <br/>
								<button class="btn btn-primary w-100">Simpan</button>
							</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
@section('js')
<script>
    

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
</script>
@endsection
@endsection