@extends('layouts.app')

@section('title', 'Dashboard Peserta')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <!-- Success Message -->
            @if($message = session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i>
                    {!! $message !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Welcome Card -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <i class="bi bi-person-circle"></i> Selamat Datang, {{ auth()->user()->name }}! 👋
                    </h4>
                    <p class="card-text text-muted">Email: <strong>{{ auth()->user()->email }}</strong></p>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle"></i> Panduan Penggunaan
                    </h5>
                </div>
                <div class="card-body">
                    <h6>Cara Melakukan Absen:</h6>
                    <ol class="mb-0">
                        <li>Admin akan memberikan <strong>QR Code</strong> untuk sesi absen</li>
                        <li>Scan QR Code menggunakan smartphone Anda</li>
                        <li>Anda akan diarahkan ke form pengisian absen</li>
                        <li>Isi data diri dengan lengkap dan klik <strong>"Konfirmasi Absen"</strong></li>
                        <li>Data absen Anda akan tercatat di sistem</li>
                    </ol>
                </div>
            </div>

            <!-- Fitur Card -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <h3 class="text-primary mb-3">
                                <i class="bi bi-qr-code"></i>
                            </h3>
                            <h5>Scan QR Code</h5>
                            <p class="text-muted">Scan QR Code dari admin untuk melakukan absen</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <h3 class="text-success mb-3">
                                <i class="bi bi-check-circle"></i>
                            </h3>
                            <h5>Konfirmasi Absen</h5>
                            <p class="text-muted">Isi form dan konfirmasi kehadiran Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="mb-2">
                        <i class="bi bi-lightbulb"></i> Tips:
                    </h6>
                    <ul class="mb-0 text-muted small">
                        <li>Pastikan smartphone Anda terhubung dengan internet</li>
                        <li>Buat akun / login sebelum melakukan absen</li>
                        <li>Setiap peserta hanya bisa absen satu kali per sesi</li>
                        <li>Hubungi admin jika ada kendala</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
