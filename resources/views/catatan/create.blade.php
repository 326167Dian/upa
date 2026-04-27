@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Catatan Harian</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('catatan.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('catatan.partials.form', [
                        'submitLabel' => 'Simpan Catatan',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
