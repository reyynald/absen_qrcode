@extends('layouts.app')

@section('title', 'Edit Data Absen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pencil-square"></i> Edit Data Absen
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle"></i>
                    <strong>Sesi:</strong> {{ $session->name }}
                    <br>
                    <small>Ubah data yang diperlukan di bawah ini</small>
                </div>

                <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person"></i> Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $attendance->name) }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jurusan" class="form-label">
                            <i class="bi bi-book"></i> Jurusan <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror"
                               id="jurusan" name="jurusan" value="{{ old('jurusan', $attendance->jurusan) }}" required>
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jam_datang" class="form-label">
                            <i class="bi bi-clock-history"></i> Jam Datang <span class="text-danger">*</span>
                        </label>
                        <input type="time" class="form-control @error('jam_datang') is-invalid @enderror"
                               id="jam_datang" name="jam_datang" value="{{ old('jam_datang', $attendance->jam_datang) }}" required>
                        @error('jam_datang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.sessions.show', $session->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
