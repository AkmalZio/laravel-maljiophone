<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ✅ Tambah ke keranjang
    public function addToCart(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('produk_id', $id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity', $request->input('quantity', 1));
        } else {
            Cart::create([
                'user_id'   => Auth::id(),
                'produk_id' => $id,
                'quantity'  => $request->input('quantity', 1),
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // ✅ Tampilkan keranjang user
    public function index()
    {
        $carts = Cart::with('produk')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('carts'));
    }

    // ✅ Hapus item dari keranjang
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang!');
    }

    // ✅ Tampilkan halaman checkout
    public function checkout()
    {
        $carts = Cart::with('produk')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong, tidak bisa checkout.');
        }

        return view('produk.buy', compact('carts'));
    }

    // ✅ Proses checkout
    public function processCheckout(Request $request)
    {
        $request->validate([
            'alamat'     => 'required|string|max:255',
            'pembayaran' => 'required|string',
        ]);

        $carts = Cart::with('produk')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong, tidak bisa checkout.');
        }

        foreach ($carts as $cart) {
            $produk = $cart->produk;

            if ($cart->quantity > $produk->stok) {
                return redirect()->route('cart.index')->with('error', "Stok {$produk->nama} tidak mencukupi.");
            }

            $total = $produk->harga * $cart->quantity;

            Purchase::create([
                'user_id'    => Auth::id(),
                'produk_id'  => $produk->id,
                'quantity'   => $cart->quantity,
                'alamat'     => $request->alamat,
                'pembayaran' => $request->pembayaran,
                'total'      => $total,
                'status'     => 'Diproses'
            ]);

            $produk->decrement('stok', $cart->quantity);
            $cart->delete();
        }

        return redirect()->route('purchase.purchases')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);

        // Validasi jumlah minimal 1
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.checkout')->with('success', 'Jumlah berhasil diperbarui!');
    }
}
