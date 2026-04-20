@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Dashboard</h2>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-muted">Login aktif</p>
                                <h3 class="mb-0">{{ auth()->user()->username }}</h3>
                            </div>
                            <div class="avatar avatar-icon avatar-lg bg-primary text-white">
                                <i class="feather icon-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-muted">Nama</p>
                                <h3 class="mb-0">{{ auth()->user()->name }}</h3>
                            </div>
                            <div class="avatar avatar-icon avatar-lg bg-success text-white">
                                <i class="feather icon-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-1 text-muted">Total Operator</p>
                        <h3 class="mb-2">{{ $operatorCount }}</h3>
                        <p class="mb-0">Kelola data operator admin dan user dari menu Operator.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-1 text-muted">Role Admin</p>
                        <h3 class="mb-0">{{ $adminCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-1 text-muted">Role User</p>
                        <h3 class="mb-0">{{ $userCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-2 text-muted">Akses Cepat</p>
                        <a href="{{ route('operators.create') }}" class="btn btn-primary">Tambah Operator</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="mb-3">Informasi Akun</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 180px;">Username</th>
                                <td>{{ auth()->user()->username }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama</th>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Role Login</th>
                                <td><span class="badge bg-info text-dark text-uppercase">{{ auth()->user()->role }}</span></td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Operator Terbaru</h4>
                    <a href="{{ route('operators.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>No Telp</th>
                                <th>Alamat Lengkap</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestOperators as $operator)
                                <tr>
                                    <td>{{ $operator->name }}</td>
                                    <td><span class="badge bg-info text-dark text-uppercase">{{ $operator->role }}</span></td>
                                    <td>{{ $operator->phone_number }}</td>
                                    <td>{{ $operator->full_address }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data operator.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection