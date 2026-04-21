@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Data Pengumuman</h2>
                @if (auth()->user()?->hasFeatureAccess('pengumuman.create'))
                    <a href="{{ route('pengumuman.create') }}" class="btn btn-primary">Tambah Pengumuman</a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-disable-last-column-sort="true">
                        <thead>
                            <tr>
                                <th>Berita</th>
                                <th>Operator Pembuat/Edit</th>
                                <th>Dibuat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengumuman as $item)
                                <tr>
                                    <td>
                                        <div class="wysiwyg-preview">{!! html_entity_decode($item->berita) !!}</div>
                                    </td>
                                    <td>{{ $item->operator?->name ?? '-' }}</td>
                                    <td>{{ $item->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
                                    <td class="text-end">
                                        @if (auth()->user()?->hasFeatureAccess('pengumuman.edit') || auth()->user()?->hasFeatureAccess('pengumuman.delete'))
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="pengumuman-action-{{ $item->id_pengumuman }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="pengumuman-action-{{ $item->id_pengumuman }}">
                                                    @if (auth()->user()?->hasFeatureAccess('pengumuman.edit'))
                                                        <li class="px-2 py-1">
                                                            <a href="{{ route('pengumuman.edit', $item) }}" class="dropdown-item rounded d-flex align-items-center gap-2" style="background-color: #fff3bf; color: #7a4b00;">
                                                                <i class="feather icon-edit-2"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (auth()->user()?->hasFeatureAccess('pengumuman.delete'))
                                                        <li class="px-2 py-1">
                                                            <form method="POST" action="{{ route('pengumuman.destroy', $item) }}" onsubmit="return confirm('Hapus pengumuman ini?');">
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
                                        @else
                                            <span class="text-muted">Lihat Saja</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($pengumuman->isEmpty())
                    <div class="text-center text-muted py-3">Belum ada pengumuman.</div>
                @endif
            </div>
        </div>
    </div>
@endsection