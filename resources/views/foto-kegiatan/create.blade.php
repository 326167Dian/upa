@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Foto Kegiatan</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('foto-kegiatan.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('foto-kegiatan.partials.form', [
                        'submitLabel' => 'Simpan Foto',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection