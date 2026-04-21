@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Pengumuman</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('pengumuman.store') }}">
                    @csrf
                    @include('pengumuman.partials.form', [
                        'submitLabel' => 'Simpan Pengumuman',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection