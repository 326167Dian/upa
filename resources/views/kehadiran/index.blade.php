@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Data Kehadiran</h2>
                <a href="{{ route('kehadiran.create') }}" class="btn btn-primary">Tambah Kehadiran</a>
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
                                    <td>{{ optional($item->waktu)->format('d M Y H:i') ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $item->hadir === 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->hadir === 1 ? 'Hadir' : 'Tidak Hadir' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->keterangan ?: '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('kehadiran.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="POST" action="{{ route('kehadiran.destroy', $item) }}" class="d-inline-block" onsubmit="return confirm('Hapus data kehadiran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data kehadiran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection