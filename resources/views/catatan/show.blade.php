@extends('layouts.espire-app')

@section('content')
    @php
        $attachments = is_array($catatan->attachments) ? array_values(array_filter($catatan->attachments, fn ($a) => is_array($a) && !empty($a['path']))) : [];
        if (empty($attachments) && !empty($catatan->file_path)) {
            $attachments = [[
                'name' => $catatan->file_name ?? basename($catatan->file_path),
                'path' => $catatan->file_path,
            ]];
        }
    @endphp
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Detail Catatan Harian</h2>
                <a href="{{ route('catatan.index') }}" class="btn btn-light border">Kembali</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 160px;">Tanggal</th>
                        <td>{{ $catatan->tgl?->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Petugas</th>
                        <td>{{ $catatan->petugas }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>
                            <div class="wysiwyg-preview">{!! html_entity_decode($catatan->deskripsi) !!}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>
                            @if (!empty($attachments))
                                <div class="d-flex flex-column gap-2">
                                    @foreach ($attachments as $attachmentIndex => $attachment)
                                        <div>
                                            <a href="{{ route('catatan.download', ['catatan' => $catatan, 'index' => $attachmentIndex]) }}" class="btn btn-sm btn-outline-success">
                                                <i class="feather icon-download me-1"></i>{{ $attachment['name'] ?? ('Lampiran '.($attachmentIndex + 1)) }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
