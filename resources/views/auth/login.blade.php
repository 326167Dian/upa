@extends('layouts.espire-auth')

@section('content')
    <div class="auth-full-height d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="m-2">
                                <div class="d-flex justify-content-center mt-3">
                                    <div class="text-center logo">
                                        <img
                                            alt="logo"
                                            class="img-fluid"
                                            src="{{ url(str_replace('%2F', '/', rawurlencode('Espire/espireadmin-10/Espire - Bootstrap Admin Template/html/demo/app/assets/images/logo/logo-fold.png'))) }}"
                                            style="height: 70px;"
                                        >
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <h3 class="fw-bolder">Sign In</h3>
                                    <p class="text-muted">Masuk dengan akun yang sudah disiapkan.</p>
                                </div>

                                <form method="POST" action="{{ route('login.store') }}">
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

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="form-group input-affix flex-column">
                                            <input
                                                id="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                type="password"
                                                placeholder="Masukkan password"
                                            >
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                                </form>

                                <div class="divider">
                                    <span class="divider-text text-muted">akun awal</span>
                                </div>

                                <div class="alert alert-info mb-0">
                                    <div class="mb-2"><strong>Admin:</strong> mysifa / 326167Dian&amp;&amp;</div>
                                    <div><strong>User:</strong> operatoruser / 326167Dian&amp;&amp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection