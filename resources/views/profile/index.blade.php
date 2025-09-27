@extends('layouts.master')
@section('title','Kontak')
@section('css')
<style>
    label{
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
                {{-- <h5 class="mb-3">Kontak Kami</h5> --}}
                <div class="contact-form">

                    <form action="{{ route('profile.update', ['profile' => $user->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('include.admin.alert')
                    
                        {{-- Nama Lengkap --}}
                        <label for="">Nama Perusahaan</label>
                        <div class="form-group mb-3">
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" placeholder="Nama Perusahaan">
                            @error('nama_lengkap')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Nomor Telepon --}}
                        <label for="">Nomor Telepon</label>
                        <div class="form-group mb-3">
                            <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $user->no_telp) }}">
                            @error('no_telp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Email --}}
                        <label for="">Email</label>
                        <div class="form-group mb-3">
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Username --}}
                        <label for="">Username (Untuk login aplikasi)</label>
                        <div class="form-group mb-3">
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}">
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Keterangan --}}
                        <p class="mt-3 text-muted"><i>Biarkan kolom password kosong jika tidak ingin mengganti password. Jika ingin mengganti password, masukkan password lama terlebih dahulu.</i></p>
                    
                        {{-- Katasandi Lama --}}
                        <label for="">Katasandi Lama</label>
                        <div class="form-group mb-3">
                            <input type="password" name="katasandi_lama" autocomplete="old-password" class="form-control @error('katasandi_lama') is-invalid @enderror">
                            @error('katasandi_lama')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Katasandi Baru --}}
                        <label for="">Katasandi Baru</label>
                        <div class="form-group mb-3">
                            <input type="password" name="katasandi_baru" class="form-control @error('katasandi_baru') is-invalid @enderror" autocomplete="new-password">
                            @error('katasandi_baru')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Konfirmasi Katasandi Baru --}}
                        <label for="">Konfirmasi Katasandi Baru</label>
                        <div class="form-group mb-3">
                            <input type="password" name="konfirmasi_katasandi_baru" class="form-control" autocomplete="new-password">
                        </div>
                    
                        {{-- Submit --}}
                        <button id="btnSave" type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                    
                   
                    
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script>
    function checkUsername(username) {
        let feedback = document.getElementById("usernameFeedback");
        let inputField = document.querySelector('input[name="username"]');

        // Ambil ID user jika sedang edit (misalnya dari input hidden)
        let userId = document.querySelector('input[name="user_id"]')?.value || "";

        if (username.length > 0) {
            fetch(`{{ url('/check-username') }}?username=${username}&id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        inputField.style.borderColor = "red";
                        feedback.style.color = "red";
                        feedback.textContent = "Username sudah digunakan!";
                        btnSave.style.display = "none"; // Sembunyikan tombol Simpan
                    } else {
                        inputField.style.borderColor = "green";
                        feedback.style.color = "green";
                        feedback.textContent = "Username tersedia!";
                        btnSave.style.display = "";
                    }
                });
        } else {
            feedback.textContent = "";
            inputField.style.borderColor = "";
        }
    }
</script>
@endsection
@endsection