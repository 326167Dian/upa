@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <div>
                    <h2 class="font-weight-normal mb-1">Kehadiran Personal Operator</h2>
                    <p class="text-muted mb-0">{{ $operator->name }} ({{ $operator->username ?? '-' }})</p>
                </div>
                <a href="{{ route('operators.index') }}" class="btn btn-light border">Kembali ke Data Operator</a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('operators.personal-attendance', $operator) }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input
                            type="date"
                            id="tanggal_mulai"
                            name="tanggal_mulai"
                            class="form-control"
                            value="{{ $startDate }}"
                        >
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input
                            type="date"
                            id="tanggal_selesai"
                            name="tanggal_selesai"
                            class="form-control"
                            value="{{ $endDate }}"
                        >
                        <small class="text-muted">Isi salah satu atau keduanya untuk filter rentang tanggal.</small>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        <a href="{{ route('operators.personal-attendance', $operator) }}" class="btn btn-light border">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Total Evaluasi</div>
                        <div class="h4 mb-0">{{ $summaryStats['total_evaluasi'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">HADIR</div>
                        <div class="h4 mb-0 text-success">{{ $summaryStats['total_hadir'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">TIDAK HADIR</div>
                        <div class="h4 mb-0 text-danger">{{ $summaryStats['total_tidak_hadir'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Persentase HADIR</div>
                        <div class="h4 mb-0">{{ number_format($summaryStats['persentase_hadir'], 1) }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal/Waktu</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendanceRows as $row)
                                @php $isHadir = (int) ($row['hadir'] ?? 0) === 1; @endphp
                                <tr>
                                    <td>{{ optional($row['waktu'] ?? null)->format('d M Y H:i') ?? '-' }}</td>
                                    <td>{{ $row['kegiatan_label'] ?? '-' }}</td>
                                    <td>
                                        @if ($isHadir)
                                            <span class="badge bg-success">HADIR</span>
                                        @else
                                            <span class="badge bg-danger">TIDAK HADIR</span>
                                            @if (!empty($row['is_inferred']))
                                                <span class="badge bg-secondary ms-1">AUTO</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $row['keterangan'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{ ($startDate !== '' || $endDate !== '') ? $filterDateLabel : '-' }}</td>
                                    <td>-</td>
                                    <td><span class="badge bg-danger">TIDAK HADIR</span></td>
                                    <td>Tidak ada data kehadiran pada rentang tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
