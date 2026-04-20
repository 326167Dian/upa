@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Operator</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('operators.update', $operator) }}">
                    @csrf
                    @method('PUT')
                    @include('operators.partials.form', [
                        'submitLabel' => 'Perbarui Operator',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection