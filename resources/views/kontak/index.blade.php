@extends('layouts.master')
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
</style>
@endsection
@section('content')
<div class="page-content-wrapper py-3">
    <div class="container">
        <!-- Contact Form -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Kontak Kami</h5>
                <div class="contact-form">
                    
                    <div class="map-responsive">
                        <iframe
                            src="{{ $identitas['maps'] }}"
                            width="600"
                            height="450"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <br/>
                        <h4><b>GIBRIG INDONESIA BERSIH</b></h4>
                        <table>
                            <tr>
                                <th valign="top" style="width: 80px;">Alamat</th>
                                <th valign="top" style="width: 10px">:</th>
                                <th>
                                    {{ strip_tags($alamat->alamat) ?? '-' }}
                                </th>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <th>:</th>
                                <th>
                                    {{ $identitas->no_telp ?? '-' }}
                                </th>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th>:</th>
                                <th>
                                    {{ $identitas->email ?? '-' }}
                                </th>
                            </tr>
                        </table>
                        
                    
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')

@endsection
@endsection