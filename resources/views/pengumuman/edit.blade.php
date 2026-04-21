@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Pengumuman</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('pengumuman.update', $pengumuman) }}">
                    @csrf
                    @method('PUT')
                    @include('pengumuman.partials.form', [
                        'submitLabel' => 'Perbarui Pengumuman',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection