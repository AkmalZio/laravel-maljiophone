<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    // ====================
    // Admin view
    // ====================
    public function index()
    {
        $purchases = Purchase::with(['produk', 'user'])->latest()->get();
        return view('purchase.index', compact('purchases'));
    }

    // ====================
    // Update status (admin only)
    // ====================
    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        if (Auth::user()->role === 'admin') {
            $purchase->status = $request->status;
            $purchase->save();

            return redirect()->back()->with('success', 'Status pembelian berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan ini.');
    }

    // ====================
    // User view
    // ====================
    public function myPurchases()
    {
        $purchases = Purchase::with('produk')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('purchase.purchases', compact('purchases'));
    }

    // ====================
    // Store pembelian
    // ====================
    public function store(Request $request, $produkId)
    {
        $produk = Produk::findOrFail($produkId);

        $purchase = new Purchase();
        $purchase->user_id = Auth::id();
        $purchase->produk_id = $produk->id;
        $purchase->quantity = $request->quantity ?? 1;
        $purchase->total_price = $produk->harga * $purchase->quantity;
        $purchase->status = 'Diproses';
        $purchase->save();

        return redirect()->route('purchase.purchases')->with('success', 'Pembelian berhasil!');
    }
}