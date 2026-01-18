@extends('layouts.app')

@section('title', 'QR Code - ' . $session->name)

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-qr-code"></i> QR Code - {{ $session->name }}
                </h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted mb-3">Scan QR Code ini untuk mengisi absen</p>

                <!-- QR Code Image Container -->
                <div style="background: #f8f9fa; padding: 3rem; border-radius: 10px; margin: 2rem 0; display: flex; justify-content: center; align-items: center;">
                    <div id="qrcode" style="background: white; padding: 1rem; display: inline-block;"></div>
                </div>

                <!-- Attendance Link -->
                <h6 class="mt-4">Link Absen:</h6>
                <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px; word-break: break-all; border-left: 4px solid #0d6efd;">
                    <small id="urlText">{{ $attendanceUrl }}</small>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyUrl()">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                    <button class="btn btn-success" onclick="downloadQR()">
                        <i class="bi bi-download"></i> Download Gambar
                    </button>
                    <a href="{{ route('admin.sessions.show', $session->id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="alert alert-info mt-4">
                    <i class="bi bi-info-circle"></i> Link ini unik untuk sesi ini. Bagikan dengan peserta melalui WhatsApp, Email, atau cetak QR Code di atas.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load QRCode Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    // Generate QR Code - dengan delay untuk pastikan library ter-load
    setTimeout(function() {
        try {
            const url = '{{ $attendanceUrl }}';
            const qrcodeDiv = document.getElementById('qrcode');
            
            // Clear any previous content
            qrcodeDiv.innerHTML = '';
            
            // Create QR Code
            new QRCode(qrcodeDiv, {
                text: url,
                width: 320,
                height: 320,
                colorDark: '#000000',
                colorLight: '#FFFFFF',
                correctLevel: QRCode.CorrectLevel.H
            });
            
            console.log('QR Code berhasil di-generate');
        } catch (error) {
            console.error('Error generating QR Code:', error);
            document.getElementById('qrcode').innerHTML = '<p style="color: red;">Gagal membuat QR Code</p>';
        }
    }, 500);

    // Copy URL to clipboard
    function copyUrl() {
        const text = document.getElementById('urlText').innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert('Link berhasil disalin!');
        }).catch(() => {
            alert('Gagal menyalin link');
        });
    }

    // Download QR Code as image
    function downloadQR() {
        setTimeout(() => {
            const canvas = document.querySelector('#qrcode canvas');
            if (canvas) {
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = 'qrcode-session-{{ $session->id }}.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                alert('QR Code belum siap. Tunggu sebentar.');
            }
        }, 300);
    }
</script>
@endsection

