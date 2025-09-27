@extends('layouts.welcome')
@section('title','Kontak')
@section('css')
<style>
.map-responsive {
    position: relative;
    padding-bottom: 56.25%; /* Rasio 16:9 */
    height: 0;
    overflow: hidden;
    border-radius: 10px;
}

.map-responsive iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
th,h4{
    color: black;
}
.visi-misi {
  padding: 60px 20px;
  background-color: #fff;
}

.container {
  max-width: 900px;
  margin: auto;
}

h1 {
  text-align: left;
  font-size: 2.5em;
  margin-bottom: 40px;
  color: #2c3e50;
}

.visi, .misi {
  margin-bottom: 40px;
}

h2 {
  font-size: 1.8em;
  color: #2980b9;
  margin-bottom: 15px;
}

.visi p {
  font-size: 1.1em;
  line-height: 1.6;
}

.misi ul {
  padding-left: 20px;
}

.misi li {
  margin-bottom: 10px;
  font-size: 1.1em;
  line-height: 1.5;
}

@media (max-width: 600px) {
  h1 {
    font-size: 2em;
  }

  h2 {
    font-size: 1.5em;
  }

  .visi p,
  .misi li {
    font-size: 1em;
  }
}

.item {
  text-align: left;
  margin-bottom: 40px;
  padding: 10px;
  border-radius: 10px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.icon {
  width: 80px;
  height: auto;
  margin-bottom: 15px;
}

.item-title {
  font-size: 16px;
  font-weight: bold;
  color: #446629;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.item p {
  font-size: 14px;
  line-height: 1.6;
}

/* Responsive */
@media (min-width: 768px) {
  .container {
    max-width: 960px;
  }

  .item-title {
    font-size: 18px;
  }

  .item p {
    font-size: 16px;
  }
}
</style>
@endsection
@section('content')
<div class="page-content-wrapper py-3">
    <div class="container">
        <!-- Contact Form -->
        <div class="card mb-3">
            <div class="card-body">
                {{-- <h5 class="mb-3">Kontak Kami</h5> --}}
                <div class="contact-form">
                    
                    <?=$visi_misi['isi_halaman']?>
                    @foreach ($visi as $item)
                        <div class="item">
                          <img src="https://ptgib.co.id/asset/img_visi/icon_visi.png" alt="Riset" class="icon" style="display: block; margin: 0 auto; width: 80px; height: auto;">
                          <h5 class="item-title" style="text-align: center">{{ $item['judul'] }}</h5>
                          <?=$item['isi_visi']?>
                        </div>
                    @endforeach

                    <h5 class="item-title" style="text-align: center">Latar Belakang</h5>
                    <?=$latar_belakang['isi_halaman']?>

                    <h5 class="item-title" style="text-align: center">Sejarah Perusahaan</h5>
                    <?=$sejarah['isi_halaman']?>

                    <h5 class="item-title" style="text-align: center">Objektif Kami</h5>
                    <?=$sejarah['isi_halaman']?>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')

@endsection
@endsection