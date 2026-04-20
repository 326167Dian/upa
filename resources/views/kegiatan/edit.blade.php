@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Kegiatan</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('kegiatan.update', $kegiatan) }}">
                    @csrf
                    @method('PUT')
                    @include('kegiatan.partials.form', [
                        'submitLabel' => 'Perbarui Kegiatan',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection