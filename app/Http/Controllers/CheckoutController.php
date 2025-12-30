<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function formCheckout()
    {
        $keranjang = Keranjang::with('produk')->where('user_id', Auth::id())->get();
        return view('checkout.form', compact('keranjang'));
    }

    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'wilayah' => 'required|string', // Validasi baru
        ]);

        // TENTUKAN HARGA ONGKIR DISINI
        $ongkir = 0;
        if ($request->wilayah == 'bandung_kota') {
            $ongkir = 10000;
        } elseif ($request->wilayah == 'bandung_barat') {
            $ongkir = 20000;
        }

        DB::beginTransaction();
        try {
            $keranjang = Keranjang::with('produk')->where('user_id', Auth::id())->get();

            if ($keranjang->isEmpty()) {
                return back()->with('error', 'Keranjang kosong!');
            }

            $subtotal = 0;
            foreach ($keranjang as $item) {
                // Cek stok dulu sebelum checkout biar aman
                if ($item->produk->stok < $item->jumlah) {
                    return back()->with('error', 'Stok produk ' . $item->produk->nama . ' tidak mencukupi!');
                }
                $subtotal += $item->produk->harga * $item->jumlah;
            }
            
            // Total Akhir = Subtotal Barang + Ongkir
            $grand_total = $subtotal + $ongkir;

            // Kita gabungkan info wilayah ke alamat biar admin tau
            $alamat_lengkap = $request->alamat_pengiriman . " (Wilayah: " . str_replace('_', ' ', strtoupper($request->wilayah)) . ")";

            $statusAwal = 'diproses';
            if ($request->metode_pembayaran != 'cod') {
                $statusAwal = 'menunggu_pembayaran'; // Status baru, pastikan enum di database support atau pakai string biasa
            }
            
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'alamat_pengiriman' => $alamat_lengkap,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $statusAwal, // Ganti ini
                'total_harga' => $grand_total,
            ]);

            foreach ($keranjang as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->produk->harga,
                ]);

                // Kurangi stok produk
                $item->produk->stok -= $item->jumlah;
                $item->produk->save();
            }

            Keranjang::where('user_id', Auth::id())->delete();

            DB::commit();
            return redirect()->route('pesanan.saya')->with('success', 'Checkout berhasil! Ongkir ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
