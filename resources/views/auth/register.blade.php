@extends('layouts.espire-auth')

@section('content')
    <div class="auth-full-height d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="m-2">
                                <div class="d-flex justify-content-center mt-3">
                                    <div class="text-center logo">
                                        <img
                                            alt="logo"
                                            class="img-fluid"
                                            src="{{ asset('logo.png') }}"
                                            style="height: 120px;"
                                        >
                                    </div>
                                </div>
                                <div class="text-center mt-3 mb-4">
                                    <h3 class="fw-bolder">Registrasi</h3>
                                   
                                </div>

                                <form method="POST" action="{{ route('register.store') }}">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input
                                            id="username"
                                            name="username"
                                            type="text"
                                            value="{{ old('username') }}"
                                            class="form-control @error('username') is-invalid @enderror"
                                            placeholder="Masukkan username"
                                            autofocus
                                        >
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input
                                            id="name"
                                            name="name"
                                            type="text"
                                            value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Masukkan nama lengkap"
                                        >
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="phone_number" class="form-label">Telepon</label>
                                        <input
                                            id="phone_number"
                                            name="phone_number"
                                            type="text"
                                            value="{{ old('phone_number') }}"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            placeholder="Masukkan nomor telepon"
                                        >
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="full_address" class="form-label">Alamat Lengkap</label>
                                        <textarea
                                            id="full_address"
                                            name="full_address"
                                            rows="4"
                                            class="form-control @error('full_address') is-invalid @enderror"
                                            placeholder="Masukkan alamat lengkap"
                                        >{{ old('full_address') }}</textarea>
                                        @error('full_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Minimal 8 karakter"
                                        >
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            type="password"
                                            class="form-control"
                                            placeholder="Ulangi password"
                                        >
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                                </form>

                                <div class="text-center mt-3">
                                    <span class="text-muted">Sudah punya akun?</span>
                                    <a href="{{ route('login') }}" class="fw-semibold">Log In</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection