{{-- resources/views/produk/index.blade.php --}}
@extends('app')

@section('title', 'MaljioPhone')

@section('content')
<div class="container mt-10 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-basket-fill me-2"></i> Daftar iPhone
        </h2>

        {{-- Tombol tambah produk untuk admin --}}
        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah
                </a>
            @endif
        @endauth
    </div>

    {{-- Pesan sukses / error --}}
    @if (session('success'))
        <div class="alert alert-success text-center shadow-sm">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center shadow-sm">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Cek apakah ada produk --}}
    @if ($produk->isEmpty())
        <div class="alert alert-info text-center shadow-sm">
            <i class="bi bi-info-circle me-1"></i> Tidak ada produk tersedia.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($produk as $p)
                <div class="col">
                    <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm produk-card">
                        {{-- Gambar produk --}}
                        @if ($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" 
                                alt="{{ $p->nama }}"
                                class="card-img-top mx-auto d-block"
                                style="height: 300px; width:300px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $p->nama }}</h5>
                            <p class="card-text text-muted small">
                                {{ $p->deskripsi ?? 'Tidak ada deskripsi.' }}
                            </p>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-primary fs-6">
                                    Rp{{ number_format($p->harga, 0, ',', '.') }}
                                </span>
                                <span class="badge {{ $p->stok > 0 ? 'bg-success' : 'bg-secondary' }}">
                                    <i class="bi bi-box-seam"></i> {{ $p->stok }}
                                </span>
                            </div>

                            <div class="mt-auto">
                                @auth
                                    @if (auth()->user()->role === 'admin')
                                        {{-- Tombol admin --}}
                                        <div class="row g-2">
                                            <div class="col">
                                                <a href="{{ route('produk.edit', $p->id) }}"
                                                    class="btn btn-warning w-100">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </div>
                                            <div class="col">
                                                <form method="POST" action="{{ route('produk.destroy', $p->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger w-100"
                                                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Tombol user --}}
                                        <form action="{{ route('cart.add', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-warning w-100 mb-2 {{ $p->stok == 0 ? 'disabled' : '' }}">
                                                <i class="bi bi-cart-plus"></i> + Keranjang
                                            </button>
                                        </form>

                                        {{-- Beli langsung --}}
                                        <a href="{{ route('produk.directCheckout', $p->id) }}" 
                                        class="btn btn-success w-100 {{ $p->stok == 0 ? 'disabled' : '' }}">
                                            <i class="bi bi-bag-check"></i> Beli Sekarang
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Style tambahan --}}
<style>
    .produk-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .produk-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(254, 231, 21, 0.5);
    }
</style>
@endsection
