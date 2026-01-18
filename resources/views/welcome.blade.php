@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row align-items-center justify-content-center" style="min-height: calc(100vh - 160px);">
    <div class="col-md-8 text-center">
        <div style="animation: fadeInDown 0.6s ease;">
            <h1 class="display-4 fw-bold mb-4">
                <i class="bi bi-qr-code" style="font-size: 4rem; color: var(--primary-color);"></i>
            </h1>
            <h2 class="mb-3">Sistem Absen QR Code</h2>
            <p class="lead text-muted mb-5">
                Solusi modern untuk pencatatan kehadiran menggunakan QR Code. 
                <br>Mudah, cepat, dan efisien.
            </p>

            @auth
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-lg btn-primary">
                            <i class="bi bi-speedometer2"></i> Dashboard Admin
                        </a>
                        <a href="{{ route('admin.sessions') }}" class="btn btn-lg btn-success">
                            <i class="bi bi-plus-circle"></i> Buat Sesi Baru
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary">
                            <i class="bi bi-house"></i> Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-lg btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('login') }}" class="btn btn-lg btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-lg btn-success">
                        <i class="bi bi-person-plus"></i> Daftar Akun
                    </a>
                </div>
            @endauth

            <div class="row mt-5 pt-5">
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="bi bi-qr-code" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                        <h5 class="mt-3">QR Code Generator</h5>
                        <p class="text-muted small">Buat dan bagikan QR Code untuk setiap sesi absen</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="bi bi-form-check" style="font-size: 2.5rem; color: var(--secondary-color);"></i>
                        <h5 class="mt-3">Form Pengisian</h5>
                        <p class="text-muted small">Form yang sederhana dan mudah diisi oleh peserta</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="bi bi-bar-chart" style="font-size: 2.5rem; color: #f59e0b;"></i>
                        <h5 class="mt-3">Laporan</h5>
                        <p class="text-muted small">Lihat dan export data kehadiran dalam format CSV</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-css')
<style>
    .feature-box {
        padding: 2rem;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .feature-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection
