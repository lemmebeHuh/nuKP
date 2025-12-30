@extends('layout/aplikasi')

@section('konten')
<style>
    body {
        background-color: #121212;
        color: #e0e0e0;
    }
    .cart-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
    }

    .cart-alert-danger {
        background-color: #3e2a2a;
        color: #e57373;
        border: 1px solid #7c2e2e;
    }

    .stok-info {
        font-size: 0.85em;
        color: #888;
        margin-top: 5px;
    }
    
    .stok-warning {
        color: #e57373; /* Merah */
        font-weight: bold;
    }
    
    .cart-title {
        text-align: center;
        color: yellowgreen;
        margin-bottom: 30px;
        font-size: 2em;
    }

    .cart-alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .cart-alert-success {
        background-color: #2a3a2a;
        color: #a3d9a5;
        border: 1px solid #3c763d;
    }
    
    .cart-empty-container {
        text-align: center;
        padding: 50px 20px;
        background-color: #1e1e1e;
        border: 1px dashed #444;
        border-radius: 10px;
    }

    .cart-empty-container h4 {
        color: #ccc;
        margin-bottom: 20px;
    }

    .cart-empty-container .btn-shopping {
        background-color: yellowgreen;
        color: #121212;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .cart-empty-container .btn-shopping:hover {
        background-color: #bef046;
    }
    
    .cart-item {
        display: flex;
        background-color: #1e1e1e;
        border-radius: 10px;
        margin-bottom: 20px;
        padding: 15px;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    .cart-item-img img {
        width: 90px;
        height: 90px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #333;
    }

    .cart-item-details {
        flex-grow: 1;
        margin-left: 20px;
    }
    .cart-item-details h5 {
        margin: 0 0 10px;
        color: white;
    }
    .cart-item-details p {
        margin: 0;
        color: #aaa;
        font-size: 0.9em;
    }

    .cart-item-actions {
        text-align: right;
    }
    .cart-item-subtotal {
        color: yellowgreen;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .btn-remove {
        background: none;
        border: 1px solid #7c2e2e;
        color: #e57373;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.8em;
        transition: all 0.3s;
    }
    .btn-remove:hover {
        background-color: #7c2e2e;
        color: white;
    }

    .cart-summary {
        background-color: #1e1e1e;
        padding: 20px;
        border-radius: 10px;
        margin-top: 30px;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.3em;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .summary-total span:last-child {
        color: yellowgreen;
    }
    
    .btn-checkout {
        display: block;
        width: 100%;
        padding: 15px;
        background-color: yellowgreen;
        color: #121212;
        border: none;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-checkout:hover {
        background-color: #bef046;
    }

</style>

<div class="cart-container">
    <h3 class="cart-title">Keranjang Belanja</h3>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="cart-alert cart-alert-success">{{ session('success') }}</div>
    @endif

    {{-- Alert Error (Untuk Stok Kurang) --}}
    @if(session('error'))
        <div class="cart-alert cart-alert-danger">{{ session('error') }}</div>
    @endif

    @if($items->isEmpty())
        <div class="cart-empty-container">
            <h4>Keranjang kamu masih kosong, nih.</h4>
            <p style="color: #888; margin-bottom: 30px;">Yuk, cari buah dan sayur segar sekarang!</p>
            <a href="{{ route('produk.semua') }}" class="btn-shopping">Mulai Belanja</a>
        </div>
    @else
        <div class="cart-items-list">
            @php 
                $total = 0; 
                $bisaCheckout = true; // Flag untuk cek apakah boleh checkout
            @endphp
            
            @foreach($items as $item)
                @php
                    $subtotal = $item->produk->harga * $item->jumlah;
                    $total += $subtotal;
                    
                    // Cek apakah jumlah di keranjang melebihi stok real-time
                    $stokKurang = $item->jumlah > $item->produk->stok;
                    if($stokKurang) {
                        $bisaCheckout = false; // Kunci tombol checkout
                    }
                @endphp
                
                <div class="cart-item" style="{{ $stokKurang ? 'border: 1px solid #e57373;' : '' }}">
                    <div class="cart-item-img">
                         @if ($item->produk->foto)
                            <img src="{{ asset('foto_produk/' . $item->produk->foto) }}" alt="{{ $item->produk->nama }}">
                        @else
                            <img src="https://via.placeholder.com/90x90?text=N/A" alt="Tidak ada foto">
                        @endif
                    </div>
                    <div class="cart-item-details">
                        <h5>{{ $item->produk->nama }}</h5>
                        <p>Rp{{ number_format($item->produk->harga) }} x {{ $item->jumlah }}</p>
                        
                        {{-- INFO SISA STOK --}}
                        <div class="stok-info">
                            @if($stokKurang)
                                <span class="stok-warning">
                                    <i class="fa fa-exclamation-triangle"></i> 
                                    Stok cuma ada {{ $item->produk->stok }}! Kurangi jumlah pembelian.
                                </span>
                            @else
                                Sisa Stok Tersedia: {{ $item->produk->stok }}
                            @endif
                        </div>

                    </div>
                    <div class="cart-item-actions">
                        <p class="cart-item-subtotal">Rp{{ number_format($subtotal) }}</p>
                        <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus item ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <div class="summary-total">
                <span>Total Belanja</span>
                <span>Rp{{ number_format($total) }}</span>
            </div>
            
            @if($bisaCheckout)
                <a href="{{ route('checkout.form') }}" class="btn-checkout">Lanjut ke Checkout</a>
            @else
                <button class="btn-checkout" style="background-color: #555; cursor: not-allowed; color: #888;" disabled>
                    Stok Tidak Mencukupi (Periksa Barang Anda)
                </button>
                <p style="text-align: center; color: #e57373; margin-top: 10px; font-size: 0.9em;">
                    Ada barang yang melebihi stok tersedia. Silakan hapus atau kurangi barang yang bertanda merah.
                </p>
            @endif
        </div>
    @endif
</div>
@endsection