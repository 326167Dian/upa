@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Kegiatan</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('kegiatan.store') }}">
                    @csrf
                    @include('kegiatan.partials.form', [
                        'submitLabel' => 'Simpan Kegiatan',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection