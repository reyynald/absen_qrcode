@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="row align-items-center justify-content-center" style="min-height: calc(100vh - 160px);">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="bi bi-key-fill"></i> Lupa Password
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
                </p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email Address
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="bi bi-send"></i> Kirim Link Reset
                        </button>
                    </div>

                    <div class="text-center">
                        <small>
                            Ingat password? <a href="{{ route('login') }}">Login</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
