@extends('app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px; border-radius: 15px;">
        
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 70px; height: 70px;">
                <i class="bi bi-shop me-1" style="font-size: 2rem;"></i>
            </div>
            <h3 class="mt-3 fw-bold">Buat Akun Baru</h3>
            <p class="text-muted">Daftar sekarang dan mulai belanja</p>
        </div>

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nama lengkap" value="{{ old('name') }}" required>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" id="email" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-shield-lock"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Ulangi password" required>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                <i class="bi bi-check-circle me-1"></i> Daftar
            </button>

            <!-- Login Link -->
            <div class="text-center mt-3">
                <small class="text-muted">Sudah punya akun?</small>
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">login sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
