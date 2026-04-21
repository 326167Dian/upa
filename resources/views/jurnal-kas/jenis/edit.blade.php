@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Jenis Transaksi</h2>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('jurnal-kas.types.update', $type) }}">
                    @csrf
                    @method('PUT')
                    @include('jurnal-kas.jenis.partials.form', [
                        'submitLabel' => 'Perbarui Jenis Transaksi',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection