@extends('app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="container my-4">
    <h2 class="mb-4 text-primary fw-bold">
        <i class="bi bi-bag-check"></i> Riwayat Pembelian
    </h2>

    @if($purchases->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Belum ada pembelian.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th> <!-- Kolom tombol update -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->produk->nama ?? '-' }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>Rp{{ number_format($purchase->total_price ?? ($purchase->produk->harga * $purchase->quantity), 0, ',', '.') }}</td>
                            <td>
                                @if($purchase->status === 'Diproses')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @elseif($purchase->status === 'Dikirim')
                                    <span class="badge bg-primary">Dikirim</span>
                                @elseif($purchase->status === 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($purchase->status === 'Dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">Belum ada</span>
                                @endif
                            </td>
                            <td>{{ $purchase->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('purchase.update', $purchase->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm mb-1">
                                        <option value="Diproses" {{ $purchase->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Dikirim" {{ $purchase->status === 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="Selesai" {{ $purchase->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Dibatalkan" {{ $purchase->status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
