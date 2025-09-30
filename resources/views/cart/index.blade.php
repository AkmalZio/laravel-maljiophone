@extends('app')

@section('title', 'Keranjang Saya')

@section('content')
<div class="container mt-5" style="max-width: 900px;">
    <h2 class="fw-bold text-primary mb-4">
        <i class="bi bi-cart-check-fill me-2"></i> Keranjang Belanja
    </h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
    @endif

    @if($carts->isEmpty())
        <div class="alert alert-info text-center p-4 rounded-3 shadow-sm">
            <i class="bi bi-info-circle me-2"></i> Keranjang Anda kosong.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $index => $cart)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $cart->produk->nama }}</strong></td>
                            <td>Rp{{ number_format($cart->produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>Rp{{ number_format($cart->produk->harga * $cart->quantity, 0, ',', '.') }}</td>
                            <td class="text-center">
                                {{-- Tombol hapus per item --}}
                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-3">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tombol checkout semua --}}
        <div class="text-end mt-4">
           <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <div class="text-end mt-4">
                <a href="{{ route('cart.checkout') }}" class="btn btn-success btn-lg rounded-3 shadow">
                    <i class="bi bi-bag-check me-1"></i> Checkout Semua
                </a>
            </div>
        </form>
        </div>
    @endif
</div>
@endsection
