@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Jenis Transaksi</h2>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('jurnal-kas.types.store') }}">
                    @csrf
                    @include('jurnal-kas.jenis.partials.form', [
                        'submitLabel' => 'Simpan Jenis Transaksi',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection