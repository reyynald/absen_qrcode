@extends('layouts.app')

@section('title', 'Terima Kasih')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="card text-center">
            <div class="card-body p-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                </div>

                <h2 class="card-title mb-3 text-success">
                    <strong>Terima Kasih!</strong>
                </h2>

                <p class="card-text text-muted mb-4">
                    Anda telah berhasil mengisi form absen untuk sesi:
                </p>

                <div class="alert alert-info mb-4">
                    <h5 class="mb-2">{{ $session->name }}</h5>
                    <small>{{ $session->description }}</small>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-sm">
                        <tr>
                            <td class="text-end"><strong>Nama:</strong></td>
                            <td class="text-start">{{ $attendance->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"><strong>Jurusan:</strong></td>
                            <td class="text-start">{{ $attendance->jurusan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"><strong>Jam Datang:</strong></td>
                            <td class="text-start">
                                @if($attendance->jam_datang)
                                    <span class="badge bg-success">{{ $attendance->jam_datang }}</span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <p class="text-muted mb-4">
                    Data Anda telah tersimpan dengan baik dalam sistem kami.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
