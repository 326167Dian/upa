@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Foto Kegiatan</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('foto-kegiatan.update', $fotoKegiatan) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('foto-kegiatan.partials.form', [
                        'submitLabel' => 'Perbarui Foto',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection