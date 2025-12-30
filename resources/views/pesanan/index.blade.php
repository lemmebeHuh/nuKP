@extends('layout/aplikasi')

@section('konten')
<style>
    /* CSS ini sama dengan redesign sebelumnya, hanya untuk tampilan */
    body {
        background-color: #121212;
        color: #e0e0e0;
    }
    .order-history-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
    }

    .page-title {
        color: yellowgreen;
        margin-bottom: 30px;
        font-size: 2em;
    }
    
    .order-empty-container {
        text-align: center;
        padding: 50px 20px;
        background-color: #1e1e1e;
        border: 1px dashed #444;
        border-radius: 10px;
    }

    .order-card {
        background-color: #1e1e1e;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        overflow: hidden;
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: #2c2c2c;
    }
    .order-card-header .order-info span {
        color: #fff;
        font-weight: bold;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: bold;
        text-transform: capitalize;
        background-color: #3e9e7f; /* Warna default */
        color: #fff;
    }
    
    .order-card-body {
        padding: 20px;
        border-top: 1px solid #333;
    }
    .order-card-body h6 {
        color: #ddd;
        margin-top: 0;
        margin-bottom: 15px;
    }
    
    .order-item-list {
        list-style-type: none;
        padding-left: 0;
    }
    .order-item-list li {
        background-color: #2a2a2a;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 8px;
        color: #ccc;
    }
    
    .order-card-footer {
        padding: 15px 20px;
        background-color: #252525;
        border-top: 1px solid #333;
    }

    .order-card-footer p {
        margin: 0 0 10px 0;
    }
    .order-card-footer p:last-child {
        margin-bottom: 0;
    }
    .order-card-footer strong {
        color: #f0f0f0;
    }
</style>

<div class="order-history-container">
    {{-- Menggunakan H2 dari kode asli Anda --}}
    <h2 class="page-title">Riwayat Pesanan Saya</h2>

    {{-- Logika @if dari kode asli Anda --}}
    @if($pesanan->isEmpty())
        {{-- Tampilan baru untuk pesan kosong, namun teks dari kode asli --}}
        <div class="order-empty-container">
            <h4>Anda belum memiliki riwayat pesanan.</h4>
        </div>
    @else
        {{-- Logika @foreach dari kode asli Anda --}}
        @foreach($pesanan as $p)
            <div class="order-card">
                <div class="order-card-header">
                    {{-- Variabel dan format dari kode asli Anda --}}
                    <div class="order-info">
                        <span>Pesanan #{{ $p->id }} - {{ $p->created_at->format('d F Y') }}</span>
                    </div>
                    {{-- Badge dengan variabel status dari kode asli --}}
                    <span class="status-badge">{{ $p->status }}</span>
                </div>

                <div class="order-card-body">
                    {{-- Variabel total_harga & alamat_pengiriman dari kode asli Anda --}}
                    <div class="order-card-footer" style="background: none; padding: 0 0 20px 0; border: none;">
                        <p><strong>Total:</strong> Rp{{ number_format($p->total_harga) }}</p>
                        <p><strong>Metode Pembayaran:</strong> 
                            @if($p->metode_pembayaran == 'cod')
                                Cash On Delivery (COD)
                            @else
                                {{ ucwords(str_replace('_', ' ', $p->metode_pembayaran)) }}
                            @endif
                        </p>
                        <p><strong>Alamat Pengiriman:</strong> {{ $p->alamat_pengiriman }}</p>

                        {{-- LOGIKA TOMBOL AKSI --}}
                        <div style="margin-top: 15px;">
                        
                        {{-- UBAH DISINI: Cek status 'menunggu_pembayaran' --}}
                        @if($p->metode_pembayaran != 'cod' && ($p->status == 'menunggu' || $p->status == 'menunggu_pembayaran'))
                            
                            <div class="alert alert-warning" style="background-color: #3e2a00; color: #ffc107; padding: 10px; border-radius: 5px; font-size: 0.9em; margin-bottom: 10px;">
                                <i class="fa fa-clock-o"></i> Menunggu Pembayaran
                            </div>
                            
                            {{-- Tombol Konfirmasi WA --}}
                            <a href="https://wa.me/6288224441157?text=Halo%20Admin%20LukyFresh,%20saya%20mau%20konfirmasi%20pembayaran%20untuk%20Pesanan%20ID:%20{{ $p->id }}" 
                               target="_blank" 
                               class="btn" 
                               style="background-color: #25D366; color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; display: inline-block;">
                                <img src="{{ asset('foto/asset/whatsapp.svg') }}" style="width: 18px; vertical-align: middle; margin-right: 5px;">
                                Konfirmasi Bukti Transfer
                            </a>
                        
                        {{-- Tombol Pesanan Diterima --}}
                        @elseif($p->status == 'dikirim')
                            <form action="{{ route('pesanan.selesai', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin pesanan sudah diterima?')">
                                    ✅ Pesanan Diterima
                                </button>
                            </form>
                        
                        {{-- Status Selesai --}}
                        @elseif($p->status == 'selesai')
                            <p class="text-success mt-2"><em>Pesanan Selesai</em></p>
                            
                        @endif

                    </div>
                    </div>

                    {{-- Teks dan list dari kode asli Anda --}}
                    <h6>Detail Item:</h6>
                    <ul class="order-item-list">
                         {{-- Loop detail dan variabelnya dari kode asli Anda --}}
                        @foreach($p->detailPesanan as $items)
                            <li>{{ $items->produk->nama }} ({{ $items->jumlah }} x Rp{{ number_format($items->harga_satuan) }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
