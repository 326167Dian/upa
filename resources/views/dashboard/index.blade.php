@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Dashboard</h2>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Pengumuman Terbaru</h4>
                            <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                        </div>

                        @if ($latestAnnouncement)
                            <p class="text-muted mb-2">
                                {{ $latestAnnouncement->created_at?->format('d-m-Y H:i') ?? '-' }}
                                | {{ $latestAnnouncement->operator?->name ?? '-' }}
                            </p>
                            <div class="wysiwyg-preview">{!! html_entity_decode($latestAnnouncement->berita) !!}</div>
                        @else
                            <p class="text-muted mb-0">Belum ada pengumuman terbaru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection