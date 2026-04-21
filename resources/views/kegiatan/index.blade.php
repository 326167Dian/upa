@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Data Kegiatan</h2>
                @if (auth()->user()?->hasFeatureAccess('kegiatan.create'))
                    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">Tambah Kegiatan</a>
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
                                <th>Deskripsi</th>
                                <th>Operator Pembuat/Edit</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kegiatan as $item)
                                <tr>
                                    <td>{{ $item->nama_kegiatan }}</td>
                                    <td>
                                        <div class="wysiwyg-preview">{!! html_entity_decode($item->deskripsi) !!}</div>
                                    </td>
                                    <td>{{ $item->operator?->name ?? '-' }}</td>
                                    <td class="text-end">
                                        @if (auth()->user()?->hasFeatureAccess('kegiatan.edit'))
                                            <a href="{{ route('kegiatan.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endif
                                        @if (auth()->user()?->hasFeatureAccess('kegiatan.delete'))
                                            <form method="POST" action="{{ route('kegiatan.destroy', $item) }}" class="d-inline-block" onsubmit="return confirm('Hapus kegiatan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data kegiatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection