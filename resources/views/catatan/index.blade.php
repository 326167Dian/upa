@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Catatan Harian</h2>
                @if (auth()->user()?->hasFeatureAccess('catatan.create'))
                    <a href="{{ route('catatan.create') }}" class="btn btn-primary">Tambah Catatan</a>
                @endif
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-disable-last-column-sort="true">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Petugas</th>
                                <th>Catatan Singkat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catatan as $item)
                                @php
                                    $attachments = is_array($item->attachments) ? array_values(array_filter($item->attachments, fn ($a) => is_array($a) && !empty($a['path']))) : [];
                                    if (empty($attachments) && !empty($item->file_path)) {
                                        $attachments = [[
                                            'name' => $item->file_name ?? basename($item->file_path),
                                            'path' => $item->file_path,
                                        ]];
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tgl?->format('d-m-Y') }}</td>
                                    <td>{{ $item->petugas }}</td>
                                    <td>
                                        <div class="wysiwyg-preview">{!! html_entity_decode($item->deskripsi) !!}</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if (auth()->user()?->hasFeatureAccess('catatan.view'))
                                                    <li class="px-2 py-1">
                                                        <a href="{{ route('catatan.show', $item) }}"
                                                            class="dropdown-item rounded d-flex align-items-center gap-2"
                                                            style="background-color: #d6eaff; color: #003d80;">
                                                            <i class="feather icon-eye"></i>
                                                            <span>Detail</span>
                                                        </a>
                                                    </li>
                                                    @foreach ($attachments as $attachmentIndex => $attachment)
                                                        <li class="px-2 py-1">
                                                            <a href="{{ route('catatan.download', ['catatan' => $item, 'index' => $attachmentIndex]) }}"
                                                                class="dropdown-item rounded d-flex align-items-center gap-2"
                                                                style="background-color: #e6ffe6; color: #1a5c1a;">
                                                                <i class="feather icon-download"></i>
                                                                <span>Download {{ $attachment['name'] ?? ('Lampiran '.($attachmentIndex + 1)) }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                @if (auth()->user()?->hasFeatureAccess('catatan.edit'))
                                                    <li class="px-2 py-1">
                                                        <a href="{{ route('catatan.edit', $item) }}"
                                                            class="dropdown-item rounded d-flex align-items-center gap-2"
                                                            style="background-color: #fff3bf; color: #7a4b00;">
                                                            <i class="feather icon-edit-2"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (auth()->user()?->hasFeatureAccess('catatan.delete'))
                                                    <li class="px-2 py-1">
                                                        <form method="POST" action="{{ route('catatan.destroy', $item) }}"
                                                            onsubmit="return confirm('Hapus catatan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="dropdown-item rounded d-flex align-items-center gap-2 w-100"
                                                                style="background-color: #ffd6d6; color: #a61e1e;">
                                                                <i class="feather icon-trash-2"></i>
                                                                <span>Hapus</span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($catatan->isEmpty())
                    <div class="text-center text-muted py-3">Belum ada catatan harian.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
