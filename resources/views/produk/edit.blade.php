@extends('app')

@section('title', 'MaljioPhone - Edit')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3 rounded-top-4">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Produk</h4>
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="bi bi-exclamation-triangle-fill"></i> Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold"><i class="bi bi-tag-fill me-1"></i> Nama Produk</label>
                    <input type="text" name="nama" class="form-control form-control-lg rounded-3" value="{{ old('nama', $produk->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label fw-semibold"><i class="bi bi-cash-coin me-1"></i> Harga</label>
                    <input type="number" name="harga" class="form-control form-control-lg rounded-3" value="{{ old('harga', $produk->harga) }}" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label fw-semibold"><i class="bi bi-box-seam me-1"></i> Stok</label>
                    <input type="number" name="stok" class="form-control form-control-lg rounded-3" value="{{ old('stok', $produk->stok) }}" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-semibold"><i class="bi bi-file-earmark-text-fill me-1"></i> Deskripsi</label>
                    <textarea name="deskripsi" class="form-control form-control-lg rounded-3" rows="4">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label fw-semibold"><i class="bi bi-image-fill me-1"></i> Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control form-control-lg rounded-3" accept="image/*">
                    @if ($produk->gambar)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" class="img-thumbnail shadow-sm rounded-3" style="max-width: 200px;">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-lg me-2"><i class="bi bi-arrow-left-circle me-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-save-fill me-1"></i> Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
