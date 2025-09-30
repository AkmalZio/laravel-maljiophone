@extends('app')

@section('title', 'Checkout')

@section('content')
<div class="container mt-5" style="max-width: 900px;">
    <h2 class="fw-bold text-primary mb-4">
        <i class="bi bi-bag-check me-2"></i> Checkout
    </h2>

    <form action="{{ route('produk.processDirectPurchase', $produk->id) }}" method="POST">
        @csrf

        {{-- Produk yang dibeli --}}
        <div class="table-responsive shadow-sm rounded-3 mb-4">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $produk->nama }}</td>
                        <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>
                            {{-- jumlah tetap 1, tidak bisa diubah --}}
                            1
                            <input type="hidden" name="quantity" value="1">
                        </td>
                        <td>
                            <span class="text-primary fw-bold">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Form Data Pembeli --}}
        <div class="mb-3">
            <label class="form-label">Nama Penerima</label>
            <input type="text" name="nama_penerima" class="form-control" placeholder="Masukkan nama penerima" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat Pengiriman</label>
            <textarea name="alamat" class="form-control" rows="4" placeholder="Masukkan alamat lengkap" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="pembayaran" class="form-select" required>
                <option value="" disabled selected>Pilih metode pembayaran</option>
                <option value="gopay">GoPay</option>
                <option value="dana">Dana</option>
                <option value="ovo">OVO</option>
                <option value="bca">Bank BCA</option>
                <option value="mandiri">Bank Mandiri</option>
                <option value="alfamart">Alfamart</option>
                <option value="indomaret">Indomaret</option>
                <option value="cod">Cash On Delivery (COD)</option>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success btn-lg rounded-3 shadow">
                <i class="bi bi-check-circle me-1"></i> Buat Pesanan
            </button>
        </div>
    </form>
</div>
@endsection
