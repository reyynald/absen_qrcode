@extends('layouts.app')

@section('title', 'Detail Sesi')

@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">{{ $session->name }}</h5>
                        <small class="text-muted">oleh {{ $session->creator->name ?? 'Admin' }}</small>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin.generateQRCode', $session->id) }}" class="btn btn-warning">
                            <i class="bi bi-qr-code"></i> QR Code
                        </a>
                        <a href="{{ route('admin.exportAttendance', $session->id) }}" class="btn btn-info">
                            <i class="bi bi-download"></i> Export CSV
                        </a>
                        <a href="{{ route('admin.sessions') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Deskripsi:</strong>
                            <br>
                            {{ $session->description ?? 'Tidak ada deskripsi' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Tanggal Mulai:</strong> {{ $session->start_date->format('d M Y H:i') }}
                        </p>
                        <p class="mb-2">
                            <strong>Tanggal Berakhir:</strong>
                            @if($session->end_date)
                                {{ $session->end_date->format('d M Y H:i') }}
                            @else
                                <span class="badge bg-secondary">Belum ditentukan</span>
                            @endif
                        </p>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3">
                    <i class="bi bi-people"></i> Daftar Peserta ({{ $session->attendances()->count() }} orang)
                </h6>

                @if($attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jurusan / Jabatan</th>
                                    <th>NIM / NIP</th>
                                    <th>Jam Datang</th>
                                    <th>Tanda Tangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $index => $attendance)
                                    <tr>
                                        <td>{{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}</td>
                                        <td><strong>{{ $attendance->name }}</strong></td>
                                        <td><small>{{ $attendance->jurusan ?? '-' }}</small></td>
                                        <td><small>{{ $attendance->nim_nip ?? '-' }}</small></td>
                                        <td>
                                            @if($attendance->jam_datang)
                                                <span class="badge bg-success">{{ substr($attendance->jam_datang, 0, 5) }}</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->signature)
                                                <img src="{{ $attendance->signature }}" alt="Signature" style="max-height: 50px; max-width: 100px; border: 1px solid #ddd; border-radius: 3px;">
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning" title="Edit data">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $attendances->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada peserta yang hadir</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
