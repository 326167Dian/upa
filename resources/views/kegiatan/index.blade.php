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
                                        @if (auth()->user()?->hasFeatureAccess('kegiatan.edit') || auth()->user()?->hasFeatureAccess('kegiatan.delete'))
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="kegiatan-action-{{ $item->id_kegiatan }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="kegiatan-action-{{ $item->id_kegiatan }}">
                                                    @if (auth()->user()?->hasFeatureAccess('kegiatan.edit'))
                                                        <li class="px-2 py-1">
                                                            <a href="{{ route('kegiatan.edit', $item) }}" class="dropdown-item rounded d-flex align-items-center gap-2" style="background-color: #fff3bf; color: #7a4b00;">
                                                                <i class="feather icon-edit-2"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (auth()->user()?->hasFeatureAccess('kegiatan.delete'))
                                                        <li class="px-2 py-1">
                                                            <form method="POST" action="{{ route('kegiatan.destroy', $item) }}" onsubmit="return confirm('Hapus kegiatan ini?');">
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