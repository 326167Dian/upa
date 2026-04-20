@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Kehadiran</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('kehadiran.update', $kehadiran) }}">
                    @csrf
                    @method('PUT')
                    @include('kehadiran.partials.form', [
                        'submitLabel' => 'Perbarui Kehadiran',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection