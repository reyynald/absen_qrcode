@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row align-items-center justify-content-center" style="min-height: calc(100vh - 160px);">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </h5>
            </div>
            <div class="card-body">
                <!-- Success Message -->
                @if($message = session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email Address
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-key"></i> Password
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="text-center mb-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-muted">
                                <small>Lupa password?</small>
                            </a>
                        @endif
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <small>
                            Belum punya akun?
                            <a href="{{ route('register') . (request('intended') ? '?intended=' . urlencode(request('intended')) : '') }}">Daftar di sini</a>
                        </small>
                    </div>

                    <!-- Demo Credentials -->
                    <div class="alert alert-info mt-4" style="font-size: 0.85rem;">
                        <strong><i class="bi bi-info-circle"></i> Demo Credentials:</strong>
                        <br><br>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <strong class="text-primary">👨‍💼 Admin:</strong>
                                <br>
                                <small>Email: admin@example.com</small>
                                <br>
                                <small>Password: admin123</small>
                            </div>
                            <div class="col-md-6">
                                <strong class="text-success">👤 User:</strong>
                                <br>
                                <small>Email: user@example.com</small>
                                <br>
                                <small>Password: user123</small>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
