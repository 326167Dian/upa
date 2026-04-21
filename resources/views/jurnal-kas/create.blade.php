@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">{{ $pageTitle }}</h2>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route($routeName) }}">
                    @csrf
                    @include('jurnal-kas.partials.form', [
                        'submitLabel' => 'Simpan Jurnal',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection