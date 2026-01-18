@extends('layouts.app')

@section('title', 'Form Absen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clipboard-check"></i> Form Pengisian Absen
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle"></i>
                    <strong>Sesi:</strong> {{ $session->name }}
                    <br>
                    <small>{{ $session->description }}</small>
                </div>

                <form action="{{ route('attendance.store', $session->qr_code_token) }}" method="POST" id="attendanceForm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person"></i> Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">
                                    <i class="bi bi-book"></i> Jurusan / Jabatan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror"
                                       id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nim_nip" class="form-label">
                                    <i class="bi bi-card-text"></i> NIM / NIP <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('nim_nip') is-invalid @enderror"
                                       id="nim_nip" name="nim_nip" value="{{ old('nim_nip') }}" required>
                                @error('nim_nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="jam_datang" class="form-label">
                            <i class="bi bi-clock-history"></i> Jam Datang <span class="text-danger">*</span>
                        </label>
                        <input type="time" class="form-control @error('jam_datang') is-invalid @enderror"
                               id="jam_datang" name="jam_datang" value="{{ old('jam_datang') }}" required>
                        @error('jam_datang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="signature" class="form-label">
                            <i class="bi bi-pen"></i> Tanda Tangan Digital <span class="text-danger">*</span>
                        </label>
                        <div id="signatureContainer" class="border rounded bg-light" style="touch-action: none; user-select: none; overflow: hidden;">
                            <canvas id="signaturePad" style="display: block; cursor: crosshair; background-color: white;"></canvas>
                        </div>
                        <small class="text-muted d-block mt-2">Tanda tangan dengan mouse atau touch</small>
                        <button type="button" class="btn btn-sm btn-warning mt-2" id="clearSignature">
                            <i class="bi bi-arrow-clockwise"></i> Hapus Tanda Tangan
                        </button>
                        <input type="hidden" id="signature" name="signature" value="{{ old('signature') }}">
                        @error('signature')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle"></i> Submit Absen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Signature Pad Library -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signaturePad');
    const container = document.getElementById('signatureContainer');
    const signatureInput = document.getElementById('signature');
    const clearBtn = document.getElementById('clearSignature');
    const form = document.getElementById('attendanceForm');

    // Initialize signature pad with preventScrolling option
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255, 255, 255, 1)',
        penColor: 'rgb(0, 0, 0)',
        minWidth: 1.5,
        maxWidth: 3,
        throttle: 16,
    });

    // Handle canvas size
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const containerWidth = container.offsetWidth;
        const containerHeight = Math.max(200, container.offsetHeight);
        
        canvas.width = containerWidth * ratio;
        canvas.height = containerHeight * ratio;
        canvas.style.width = containerWidth + 'px';
        canvas.style.height = containerHeight + 'px';
        
        const ctx = canvas.getContext('2d');
        ctx.scale(ratio, ratio);
    }
    
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Prevent default touch behavior
    canvas.addEventListener('touchstart', function(e) {
        e.preventDefault();
    });
    
    canvas.addEventListener('touchmove', function(e) {
        e.preventDefault();
    });
    
    canvas.addEventListener('touchend', function(e) {
        e.preventDefault();
    });

    // Clear button
    clearBtn.addEventListener('click', function(e) {
        e.preventDefault();
        signaturePad.clear();
        signatureInput.value = '';
    });

    // On form submit, save signature
    form.addEventListener('submit', function(e) {
        if (signaturePad.isEmpty()) {
            e.preventDefault();
            alert('Tanda tangan digital tidak boleh kosong. Silakan tandatangani terlebih dahulu.');
            return false;
        }
        signatureInput.value = signaturePad.toDataURL();
    });
});
</script>

<style>
html, body {
    overflow-x: hidden;
}

#signatureContainer {
    width: 100%;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

#signaturePad {
    display: block;
    border: 1px solid #ccc;
    cursor: crosshair;
    background-color: white;
    width: 100% !important;
    height: 200px !important;
    touch-action: none;
    user-select: none;
}

#signaturePad:active {
    outline: none;
}
</style>
@endsection
