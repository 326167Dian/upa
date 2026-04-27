@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Catatan Harian</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('catatan.update', $catatan) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('catatan.partials.form', [
                        'submitLabel' => 'Perbarui Catatan',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
