@extends('app')

@section('title', 'Login')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 420px; border-radius: 15px;">

            <!-- Header -->
            <div class="text-center mb-4">
                <div class="bg-primary text-white rounded-circle d-inline-flex justify-content-center align-items-center"
                    style="width: 70px; height: 70px;">
                    <i class="bi bi-shop me-1" style="font-size: 2rem;"></i>
                </div>
                <h3 class="mt-3 fw-bold">Selamat Datang!</h3>
                <p class="text-muted">Silahkan login untuk berbelanja</p>
            </div>

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="contoh@email.com" required value="{{ old('email') }}">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" id="password" placeholder="password"
                            required>
                    </div>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </button>

                <!-- Link Register -->
                <div class="text-center mt-3">
                    <small class="text-muted">Belum punya akun?</small>
                    <a href="{{ route('register') }}" class="fw-semibold text-decoration-none"> daftar sekarang</a>
                </div>
            </form>
        </div>
    </div>
@endsection
