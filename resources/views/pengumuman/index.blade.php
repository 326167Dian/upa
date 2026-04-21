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
                                        @if (auth()->user()?->hasFeatureAccess('pengumuman.edit'))
                                            <a href="{{ route('pengumuman.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endif
                                        @if (auth()->user()?->hasFeatureAccess('pengumuman.delete'))
                                            <form method="POST" action="{{ route('pengumuman.destroy', $item) }}" class="d-inline-block" onsubmit="return confirm('Hapus pengumuman ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        @endif
                                        @if (! auth()->user()?->hasFeatureAccess('pengumuman.edit') && ! auth()->user()?->hasFeatureAccess('pengumuman.delete'))
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