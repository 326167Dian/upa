@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Data Operator</h2>
                <a href="{{ route('operators.create') }}" class="btn btn-primary">Tambah Operator</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('operators.index') }}" class="row mb-4">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Pencarian</label>
                        <input
                            id="search"
                            name="search"
                            type="text"
                            class="form-control"
                            value="{{ $filters['search'] }}"
                            placeholder="Cari nama, no telp, atau alamat"
                        >
                    </div>
                    <div class="col-md-4">
                        <label for="role" class="form-label">Filter Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="">Semua role</option>
                            <option value="admin" @selected($filters['role'] === 'admin')>Admin</option>
                            <option value="user" @selected($filters['role'] === 'user')>User</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="w-100 d-flex operator-toolbar">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('operators.index') }}" class="btn btn-light border">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>No Telp</th>
                                <th>Alamat Lengkap</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($operators as $operator)
                                <tr>
                                    <td>{{ $operator->name }}</td>
                                    <td><span class="badge bg-info text-dark text-uppercase">{{ $operator->role }}</span></td>
                                    <td>{{ $operator->phone_number }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit(trim(strip_tags($operator->full_address)), 90) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('operators.edit', $operator) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @if (auth()->user()->role === 'admin')
                                            <form method="POST" action="{{ route('operators.destroy', $operator) }}" class="d-inline-block" onsubmit="return confirm('Hapus operator ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data operator.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $operators->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection