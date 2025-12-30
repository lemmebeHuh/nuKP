<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)
            ->with('detailPesanan.produk')
            ->latest()
            ->get();

        return view('pesanan.index', compact('pesanan'));
    }
    public function selesai($id)
{
    // Cari pesanan punya user yang login
    $pesanan = Pesanan::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // Hanya bisa diselesaikan jika statusnya 'dikirim'
    // Kalau mau lebih fleksibel, bisa tambah logic lain
    if ($pesanan->status == 'dikirim') {
        $pesanan->status = 'selesai';
        $pesanan->save();
        return back()->with('success', 'Terima kasih! Pesanan telah diselesaikan.');
    }

    return back()->with('error', 'Pesanan belum dikirim atau sudah selesai.');
}
}
