@extends('app')

@section('title', 'MaljioPhone - Tambah')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3 rounded-top-4">
            <h4 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Produk</h4>
        </div>

        <div class="card-body p-4">
            {{-- Pesan error --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan!
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold">
                        <i class="bi bi-tag-fill me-1"></i> Nama Produk
                    </label>
                    <input type="text" 
                           name="nama" 
                           class="form-control form-control-lg rounded-3" 
                           id="nama" 
                           value="{{ old('nama') }}" 
                           placeholder="Masukkan nama produk" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-semibold">
                        <i class="bi bi-file-earmark-text-fill me-1"></i> Deskripsi
                    </label>
                    <textarea name="deskripsi" 
                              class="form-control form-control-lg rounded-3" 
                              id="deskripsi" 
                              rows="3" 
                              placeholder="Tuliskan deskripsi produk">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label fw-semibold">
                        <i class="bi bi-cash-coin me-1"></i> Harga (Rp)
                    </label>
                    <input type="number" 
                           name="harga" 
                           class="form-control form-control-lg rounded-3" 
                           id="harga" 
                           value="{{ old('harga') }}" 
                           placeholder="Masukkan harga produk" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label fw-semibold">
                        <i class="bi bi-box-seam me-1"></i> Stok
                    </label>
                    <input type="number" 
                           name="stok" 
                           class="form-control form-control-lg rounded-3" 
                           id="stok" 
                           value="{{ old('stok') }}" 
                           placeholder="Masukkan jumlah stok" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label fw-semibold">
                        <i class="bi bi-image-fill me-1"></i> Gambar Produk
                    </label>
                    <input type="file" 
                           name="gambar" 
                           class="form-control form-control-lg rounded-3" 
                           id="gambar" 
                           accept="image/*">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-lg me-2">
                        <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-save-fill me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
