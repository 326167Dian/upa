@extends('layouts.espire-app')

@section('content')
    @php
        $avatarUrl = $operator->avatar_path ? asset('storage/'.$operator->avatar_path) : asset('images/cakep.png');
    @endphp

    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Edit Profil</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row align-items-start">
                        <div class="col-lg-4 mb-4">
                            <label class="form-label d-block">Gambar Icon</label>
                            <div class="mb-3">
                                <div class="avatar avatar-circle avatar-image border" style="width: 120px; height: 120px; line-height: 120px;">
                                    <img src="{{ $avatarUrl }}" alt="Avatar Profil">
                                </div>
                            </div>
                            <input id="avatar" name="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format gambar JPG, PNG, WEBP. Maksimal 2 MB.</small>
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">No Telp</label>
                                <input
                                    id="phone_number"
                                    name="phone_number"
                                    type="text"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    value="{{ old('phone_number', $operator->phone_number) }}"
                                >
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="full_address" class="form-label">Alamat Lengkap</label>
                                <textarea id="full_address" name="full_address" rows="4" class="form-control @error('full_address') is-invalid @enderror">{{ old('full_address', $operator->full_address) }}</textarea>
                                @error('full_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Saat Ini</label>
                                        <input id="current_password" name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror">
                                        <small class="text-muted">Isi jika ingin mengganti password.</small>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection