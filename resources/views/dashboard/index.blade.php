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
                        <p class="mb-1 text-muted">Total Kegiatan</p>
                        <h3 class="mb-2">{{ $kegiatanCount }}</h3>
                        <p class="mb-0">Pantau dan kelola kegiatan dari menu Kegiatan.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-1 text-muted">Total Kehadiran</p>
                        <h3 class="mb-2">{{ $kehadiranCount }}</h3>
                        <p class="mb-0">Kelola absensi operator pada setiap kegiatan dari menu Kehadiran.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-2 text-muted">Akses Cepat</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('operators.create') }}" class="btn btn-primary">Tambah Operator</a>
                            <a href="{{ route('kegiatan.create') }}" class="btn btn-outline-primary">Tambah Kegiatan</a>
                            <a href="{{ route('kehadiran.create') }}" class="btn btn-outline-primary">Tambah Kehadiran</a>
                        </div>
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
                    <table class="table table-hover" data-datatable="true" data-page-length="5">
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
                                    <td>{{ \Illuminate\Support\Str::limit(trim(strip_tags($operator->full_address)), 90) }}</td>
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

        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Kegiatan Terbaru</h4>
                    <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-page-length="5">
                        <thead>
                            <tr>
                                <th>Nama Kegiatan</th>
                                <th>Deskripsi</th>
                                <th>Operator</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestKegiatan as $item)
                                <tr>
                                    <td>{{ $item->nama_kegiatan }}</td>
                                    <td>
                                        <div class="wysiwyg-preview">{!! html_entity_decode($item->deskripsi) !!}</div>
                                    </td>
                                    <td>{{ $item->operator?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data kegiatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Kehadiran Terbaru</h4>
                    <a href="{{ route('kehadiran.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-page-length="5">
                        <thead>
                            <tr>
                                <th>Operator</th>
                                <th>Kegiatan</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestKehadiran as $item)
                                <tr>
                                    <td>{{ $item->operator?->name ?? '-' }}</td>
                                    <td>{{ $item->kegiatan?->nama_kegiatan ?? '-' }}</td>
                                    <td>{{ optional($item->waktu)->format('d M Y H:i') ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $item->hadir === 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->hadir === 1 ? 'Hadir' : 'Tidak Hadir' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data kehadiran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection