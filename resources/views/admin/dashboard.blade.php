@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mt-5">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text">Total Sesi</p>
                        <h2 class="card-title">{{ $totalSessions }}</h2>
                    </div>
                    <i class="bi bi-calendar-event" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text">Total Hadir</p>
                        <h2 class="card-title">{{ $totalAttendance }}</h2>
                    </div>
                    <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-ul"></i> Sesi Terbaru
                    </h5>
                    <a href="{{ route('admin.createSession') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Buat Sesi Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recentSessions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Sesi</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Hadir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSessions as $session)
                                    <tr>
                                        <td>
                                            <strong>{{ $session->name }}</strong>
                                            <br>
                                            <small class="text-muted">oleh {{ $session->creator->name }}</small>
                                        </td>
                                        <td>{{ $session->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $session->attendances()->count() }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.sessions.show', $session->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada sesi absen</p>
                        <a href="{{ route('admin.createSession') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Buat Sesi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
