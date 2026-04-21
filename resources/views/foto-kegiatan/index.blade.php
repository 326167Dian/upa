@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Foto Kegiatan</h2>
                @if (auth()->user()?->hasFeatureAccess('foto_kegiatan.create'))
                    <a href="{{ route('foto-kegiatan.create') }}" class="btn btn-primary">Tambah Foto Kegiatan</a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-disable-last-column-sort="true">
                        <thead>
                            <tr>
                                <th>Nama Kegiatan</th>
                                <th>Foto</th>
                                <th>Keterangan</th>
                                <th>Dibuat Oleh</th>
                                <th>Dibuat Pada</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fotoKegiatan as $item)
                                <tr>
                                    <td>{{ $item->kegiatan?->nama_kegiatan ?? '-' }}</td>
                                    <td>
                                        <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto kegiatan" class="rounded border" style="width: 84px; height: 84px; object-fit: cover;">
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(trim(strip_tags($item->keterangan)), 120) }}</td>
                                    <td>{{ $item->operator?->name ?? '-' }}</td>
                                    <td>{{ $item->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
                                    <td class="text-end">
                                        @if (auth()->user()?->hasFeatureAccess('foto_kegiatan.edit'))
                                            <a href="{{ route('foto-kegiatan.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endif
                                        @if (auth()->user()?->hasFeatureAccess('foto_kegiatan.delete'))
                                            <form method="POST" action="{{ route('foto-kegiatan.destroy', $item) }}" class="d-inline-block" onsubmit="return confirm('Hapus foto kegiatan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($fotoKegiatan->isEmpty())
                    <div class="text-center text-muted py-3">Belum ada data foto kegiatan.</div>
                @endif
            </div>
        </div>
    </div>
@endsection