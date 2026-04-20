@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Operator</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('operators.store') }}">
                    @csrf
                    @include('operators.partials.form', [
                        'submitLabel' => 'Simpan Operator',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection