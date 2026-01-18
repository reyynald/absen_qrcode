@extends('layouts.app')

@section('title', 'Daftar Sesi')

@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-event"></i> Daftar Sesi Absen
                    </h5>
                    <a href="{{ route('admin.createSession') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Buat Sesi Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($sessions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Sesi</th>
                                    <th>Dibuat oleh</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Jumlah Hadir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                    <tr>
                                        <td>
                                            <strong>{{ $session->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($session->description, 50) }}</small>
                                        </td>
                                        <td>{{ $session->creator->name }}</td>
                                        <td>{{ $session->start_date->format('d M Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $session->attendances()->count() }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.sessions.show', $session->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.generateQRCode', $session->id) }}" class="btn btn-sm btn-warning" title="Lihat QR Code">
                                                <i class="bi bi-qr-code"></i>
                                            </a>
                                            <a href="{{ route('admin.exportAttendance', $session->id) }}" class="btn btn-sm btn-secondary" title="Export CSV">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            @if(auth()->id() === $session->created_by || auth()->user()->is_admin)
                                                <form action="{{ route('admin.deleteSession', $session->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $sessions->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada sesi absen</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
