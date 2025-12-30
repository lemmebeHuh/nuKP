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

        // Cek dulu barangnya ada di keranjang atau belum
        $keranjangItem = Keranjang::where('user_id', $userId)
                                ->where('produk_id', $produk->id)
                                ->first();

        // Hitung total yang ingin dibeli user (jumlah di keranjang + jumlah baru yg mau ditambah)
        $jumlahSaatIni = $keranjangItem ? $keranjangItem->jumlah : 0;
        $totalAkanDibeli = $jumlahSaatIni + $request->jumlah;

        // --- VALIDASI STOK DISINI ---
        if ($totalAkanDibeli > $produk->stok) {
            // Kalau mau beli lebih dari stok, kita tolak
            $pesan = 'Stok tidak cukup! Sisa stok produk ini hanya ' . $produk->stok . '. ';
            if($jumlahSaatIni > 0){
                $pesan .= '(Kamu sudah punya ' . $jumlahSaatIni . ' di keranjang)';
            }
        }

        if ($keranjangItem) {
            $keranjangItem->jumlah += $request->jumlah;
            $keranjangItem->save();
        } else {
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $produk->id,
                'jumlah' => $request->jumlah,
            ]);
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
