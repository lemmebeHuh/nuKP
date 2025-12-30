<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('produk')->where('user_id', Auth::id())->get();
        return view('keranjang.index', compact('items'));
    }

    public function tambah(Request $request, $id)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);

        $produk = Produk::findOrFail($id);
        $userId = Auth::id();

        $keranjangItem = Keranjang::where('user_id', $userId)
                                ->where('produk_id', $produk->id)
                                ->first();

        if ($keranjangItem) {
            // Jika sudah ada, tambahkan jumlahnya (ini sudah benar)
            $keranjangItem->jumlah += $request->jumlah;
            $keranjangItem->save();
        } else {
            // Jika belum ada, buat item baru
            // ====================================================================
            // UBAH BAGIAN INI
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $produk->id,
                'jumlah' => $request->jumlah, // Gunakan jumlah dari input form
            ]);
            // ====================================================================
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function hapus($id)
    {
        $item = Keranjang::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
