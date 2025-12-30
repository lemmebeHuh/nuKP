@extends('layout/aplikasi')

@section('konten')
<style>
    body {
        background-color: #121212;
        color: #e0e0e0;
    }
    .checkout-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 20px;
    }

    .checkout-title {
        text-align: center;
        color: yellowgreen;
        margin-bottom: 30px;
        font-size: 2em;
    }
    
    .checkout-layout {
        display: flex;
        gap: 30px;
    }
    
    .form-section {
        flex: 2; /* Takes 2/3 of the space */
        background-color: #1e1e1e;
        padding: 30px;
        border-radius: 10px;
    }
    
    .summary-section {
        flex: 1; /* Takes 1/3 of the space */
        background-color: #1e1e1e;
        padding: 30px;
        border-radius: 10px;
        height: fit-content; /* Agar tingginya sesuai konten */
    }

    .form-section h4, .summary-section h4 {
        color: white;
        margin-top: 0;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 1px solid #333;
    }

    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #ccc;
        font-size: 0.9em;
    }

    .form-control-dark {
        width: 100%;
        padding: 12px;
        background-color: #2c2c2c;
        border: 1px solid #444;
        border-radius: 5px;
        color: #e0e0e0;
        font-size: 1em;
    }

    .form-control-dark:focus {
        outline: none;
        border-color: yellowgreen;
        background-color: #333;
    }

    textarea.form-control-dark {
        resize: vertical;
        min-height: 100px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95em;
    }
    .summary-item .item-name {
        color: #ddd;
    }
    .summary-item .item-price {
        color: #bbb;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.3em;
        font-weight: bold;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #333;
    }
    .summary-total .total-label {
        color: white;
    }
    .summary-total .total-amount {
        color: yellowgreen;
    }

    .btn-process-order {
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
        margin-top: 20px;
    }
    .btn-process-order:hover {
        background-color: #bef046;
    }
</style>

<div class="checkout-container">
    <h3 class="checkout-title">Checkout</h3>

    <form action="{{ route('checkout.proses') }}" method="POST" class="checkout-layout">
        @csrf
        <div class="form-section">
            <h4>Alamat Pengiriman</h4>
            <div class="form-group">
                <label for="nama_penerima">Nama Penerima</label>
                <input type="text" class="form-control-dark" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima', Auth::user()->name) }}" required>
            </div>
            <div class="form-group">
                <label for="alamat_pengiriman">Alamat Lengkap</label>
                <textarea class="form-control-dark" id="alamat_pengiriman" name="alamat_pengiriman" rows="4" required>{{ old('alamat_pengiriman') }}</textarea>
            </div>
            <div class="form-group">
                <label for="wilayah">Wilayah Pengiriman (Ongkir Flat)</label>
                <select class="form-control-dark" id="wilayah" name="wilayah" required>
                    <option value="">-- Pilih Wilayah --</option>
                    <option value="bandung_kota">Bandung Kota (Rp 10.000)</option>
                    <option value="bandung_barat">Bandung Barat (Rp 20.000)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telepon">Nomor Telepon (WhatsApp)</label>
                <input type="text" class="form-control-dark" id="telepon" name="telepon" value="{{ old('telepon') }}" required placeholder="Contoh: 081234567890">
            </div>

            <h4 style="margin-top: 40px;">Metode Pembayaran</h4>
            <div class="form-group">
                <label for="metode_pembayaran">Pilih Metode Pembayaran</label>
                <select class="form-control-dark" id="metode_pembayaran" name="metode_pembayaran" required onchange="cekMetodePembayaran()">
                    <option value="cod">Cash on Delivery (COD)</option>
                    <option value="transfer_bca">Transfer Bank BCA</option>
                    <option value="transfer_mandiri">Transfer Bank Mandiri</option>
                    <option value="ewallet_dana">E-Wallet DANA</option>
                </select>
            </div>

            {{-- Info Rekening (Hidden by default, muncul via JS) --}}
            <div id="info-transfer" style="display: none; background-color: #2c2c2c; padding: 15px; border-radius: 5px; border: 1px solid yellowgreen; margin-bottom: 20px;">
                <h5 style="color: yellowgreen; margin-top: 0;">Instruksi Pembayaran</h5>
                <p style="color: #ccc; font-size: 0.9em;">Silakan transfer sesuai total pesanan ke:</p>
                
                <div id="rek-bca" class="rek-info" style="display: none;">
                    <strong style="color: white; font-size: 1.1em;">BCA: 123-456-7890</strong><br>
                    <span style="color: #aaa;">a.n Luky Fresh Official</span>
                </div>

                <div id="rek-mandiri" class="rek-info" style="display: none;">
                    <strong style="color: white; font-size: 1.1em;">MANDIRI: 000-111-222-333</strong><br>
                    <span style="color: #aaa;">a.n Luky Fresh Official</span>
                </div>

                <div id="rek-dana" class="rek-info" style="display: none;">
                    <strong style="color: white; font-size: 1.1em;">DANA: 0812-3456-7890</strong><br>
                    <span style="color: #aaa;">a.n Luky Fresh</span>
                </div>
                
                <p style="color: #e57373; font-size: 0.85em; margin-top: 10px; margin-bottom: 0;">
                    *Pesanan akan diproses setelah bukti transfer dikirim via WhatsApp.
                </p>
            </div>

            {{-- Script Javascript Sederhana buat Show/Hide --}}
            <script>
                function cekMetodePembayaran() {
                    var dropdown = document.getElementById("metode_pembayaran");
                    var infoBox = document.getElementById("info-transfer");
                    var val = dropdown.value;

                    // Reset semua info rekening dulu
                    document.querySelectorAll('.rek-info').forEach(el => el.style.display = 'none');

                    if (val === 'cod') {
                        infoBox.style.display = 'none';
                    } else {
                        infoBox.style.display = 'block';
                        
                        if(val === 'transfer_bca') document.getElementById('rek-bca').style.display = 'block';
                        if(val === 'transfer_mandiri') document.getElementById('rek-mandiri').style.display = 'block';
                        if(val === 'ewallet_dana') document.getElementById('rek-dana').style.display = 'block';
                    }
                }
            </script>
            
            <button type="submit" class="btn-process-order">Buat Pesanan</button>
        </div>

        <div class="summary-section">
            <h4>Ringkasan Pesanan</h4>
            @php $total = 0; @endphp
            @foreach($keranjang as $item)
                @php
                    $subtotal = $item->produk->harga * $item->jumlah;
                    $total += $subtotal;
                @endphp
                <div class="summary-item">
                    <span class="item-name">{{ $item->produk->nama }} (x{{ $item->jumlah }})</span>
                    <span class="item-price">Rp{{ number_format($subtotal) }}</span>
                </div>
            @endforeach

            <div class="summary-total">
                <span class="total-label">Total</span>
                <span class="total-amount">Rp{{ number_format($total) }}</span>
            </div>
        </div>
    </form>
</div>
@endsection