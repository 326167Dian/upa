@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Data Kehadiran</h2>
                @if (auth()->user()?->hasFeatureAccess('kehadiran.create'))
                    <a href="{{ route('kehadiran.create') }}" class="btn btn-primary">Tambah Kehadiran</a>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('kehadiran.index') }}" class="d-flex flex-wrap align-items-end gap-2">
                    <div class="grow" style="min-width: 250px;">
                        <label for="waktu" class="form-label mb-2">Filter Berdasarkan Tanggal</label>
                        <select id="waktu" name="waktu" class="form-select">
                            <option value="">-- Tampilkan Semua --</option>
                            @forelse ($availableDates as $date)
                                <option value="{{ $date['value'] }}" @selected($selectedDate === $date['value'])>
                                    {{ $date['label'] }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada data tanggal</option>
                            @endforelse
                        </select>
                    </div>
                    <div style="min-width: 200px;">
                        <label for="status" class="form-label mb-2">Status Kehadiran</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">-- Tampilkan Semua --</option>
                            <option value="1" @selected($selectedStatus === '1')>Hadir</option>
                            <option value="0" @selected($selectedStatus === '0')>Tidak Hadir</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('kehadiran.export', array_filter(['waktu' => $selectedDate ?: null, 'status' => $selectedStatus !== '' ? $selectedStatus : null])) }}" class="btn btn-success">Export Excel</a>
                    @if ($selectedDate || $selectedStatus !== '')
                        <a href="{{ route('kehadiran.index') }}" class="btn btn-secondary">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-disable-last-column-sort="true">
                        <thead>
                            <tr>
                                <th>Operator</th>
                                <th>Kegiatan</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kehadiran as $item)
                                <tr>
                                    <td>{{ $item->operator?->name ?? '-' }}</td>
                                    <td>{{ $item->kegiatan?->nama_kegiatan ?? '-' }}</td>
                                    <td>
                                        @if ($item->waktu)
                                            <span title="{{ $item->waktu->format('d M Y H:i') }}">
                                                {{ $item->waktu->format('d M Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->hadir === 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->hadir === 1 ? 'Hadir' : 'Tidak Hadir' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->keterangan ?: '-' }}</td>
                                    <td class="text-end">
                                        @if (auth()->user()?->hasFeatureAccess('kehadiran.edit') || auth()->user()?->hasFeatureAccess('kehadiran.delete'))
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="kehadiran-action-{{ $item->id_kehadiran }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="kehadiran-action-{{ $item->id_kehadiran }}">
                                                    @if (auth()->user()?->hasFeatureAccess('kehadiran.edit'))
                                                        <li class="px-2 py-1">
                                                            <a href="{{ route('kehadiran.edit', $item) }}" class="dropdown-item rounded d-flex align-items-center gap-2" style="background-color: #fff3bf; color: #7a4b00;">
                                                                <i class="feather icon-edit-2"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (auth()->user()?->hasFeatureAccess('kehadiran.delete'))
                                                        <li class="px-2 py-1">
                                                            <form method="POST" action="{{ route('kehadiran.destroy', $item) }}" onsubmit="return confirm('Hapus data kehadiran ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item rounded d-flex align-items-center gap-2 w-100" style="background-color: #ffd6d6; color: #a61e1e;">
                                                                    <i class="feather icon-trash-2"></i>
                                                                    <span>Hapus</span>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        @if ($selectedDate)
                                            Tidak ada data kehadiran pada tanggal {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}.
                                        @else
                                            Belum ada data kehadiran.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection