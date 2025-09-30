<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Purchase;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // ========================
    // 🔹 Produk
    // ========================

    // Tampilkan semua produk
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    // Form tambah produk
    public function create()
    {
        return view('produk.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required',
            'harga'  => 'required|numeric',
            'stok'   => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        Produk::create($data);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    // Update produk
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama'   => 'required',
            'harga'  => 'required|numeric',
            'stok'   => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        $produk->update($data);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    // Hapus produk
    public function destroy(Produk $produk)
    {
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // ========================
    // 🔹 Pembelian langsung dari produk
    // ========================

    public function showBuyForm($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.buy', compact('produk'));
    }

    public function processPurchase(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'quantity'   => 'required|integer|min:1|max:' . $produk->stok,
            'alamat'     => 'required|string',
            'pembayaran' => 'required|string',
        ]);

        $quantity = $request->input('quantity');
        $total = $produk->harga * $quantity;

        Purchase::create([
            'user_id'    => Auth::id(),
            'produk_id'  => $produk->id,
            'quantity'   => $quantity,
            'alamat'     => $request->input('alamat'),
            'pembayaran' => $request->input('pembayaran'),
            'total'      => $total,
            'status'     => 'Diproses' // 🔹 TAMBAHKAN STATUS DEFAULT
        ]);

        $produk->decrement('stok', $quantity);

        return redirect()->route('purchase.purchases') // 🔹 UBAH redirect ke riwayat pembelian user
            ->with('success', 'Pembelian berhasil! Terima kasih telah berbelanja.');
    }

    // ========================
    // 🔹 Checkout dari keranjang
    // ========================

    public function showBuyFormFromCart()
    {
        $carts = Cart::with('produk')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        return view('produk.buy', compact('carts'));
    }

    public function processPurchaseFromCart(Request $request)
    {
        $carts = Cart::with('produk')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'alamat'     => 'required|string',
            'pembayaran' => 'required|string',
        ]);

        foreach ($carts as $cart) {
            $total = $cart->produk->harga * $cart->quantity;

            Purchase::create([
                'user_id'    => Auth::id(),
                'produk_id'  => $cart->produk_id,
                'quantity'   => $cart->quantity,
                'alamat'     => $request->input('alamat'),
                'pembayaran' => $request->input('pembayaran'),
                'total'      => $total,
                'status'     => 'Diproses' // 🔹 TAMBAHKAN STATUS DEFAULT
            ]);

            $cart->produk->decrement('stok', $cart->quantity);
            $cart->delete();
        }

        return redirect()->route('purchase.purchases')
            ->with('success', 'Checkout berhasil! Pesanan sedang diproses.');
    }

    public function directCheckout($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.direct_checkout', compact('produk'));
    }

    public function processDirectPurchase(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // simpan ke tabel pembelian
        Purchase::create([
            'user_id'       => auth()->id(),
            'produk_id'     => $produk->id,
            'quantity'      => $request->quantity,
            'total'         => $produk->harga * $request->quantity,
            'nama_penerima' => $request->nama_penerima,
            'telepon'       => $request->telepon,
            'alamat'        => $request->alamat,
            'pembayaran'    => $request->pembayaran,
            'status'        => 'Diproses' // 🔹 TAMBAHKAN STATUS DEFAULT
        ]);

        return redirect()->route('purchase.purchases')->with('success', 'Pesanan berhasil dibuat!');
    }

    // 🔹 HAPUS METHOD myPurchases() DARI SINI - SUDAH DIPINDAH KE PurchaseController
}