@extends('layout/aplikasi')

@section('konten')
<style>
    body {
        background-color: #121212;
        color: #e0e0e0;
    }

    /* Main container for the product view */
    .product-view-container {
        max-width: 1100px;
        margin: 50px auto;
        padding: 30px;
    }

    /* The card that holds the content */
    .product-card {
        background-color: #1e1e1e;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    }

    /* Left column for the image */
    .image-column {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-column img {
        max-width: 500px;
        border-radius: 10px;
        border: 1px solid #444;
    }

    /* Right column for the details */
    .details-column {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 35px;
    }
    
    .product-breadcrumb {
        font-size: 0.9em;
        color: #888;
        margin-bottom: 8px;
    }
    
    .product-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .product-price {
        font-size: 2.2rem;
        font-weight: 500;
        color: yellowgreen;
        margin-bottom: 25px;
    }


    .stock-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 25px;
        width: fit-content;
    }
    .stock-habis { background-color: #d32f2f; color: white; border: 1px solid #b71c1c; }
    .stock-nipis { background-color: #ffa000; color: #121212; border: 1px solid #ff8f00; }
    .stock-aman { background-color: #2e7d32; color: white; border: 1px solid #1b5e20; }

    /* Form Actions Section */
    .product-actions-form {
        display: flex;
        align-items: stretch; /* Makes button and input same height */
        gap: 15px; /* Space between input and button */
        margin-bottom: 30px;
    }

    .quantity-input {
        width: 80px;
        flex-shrink: 0; /* Prevents input from shrinking */
        padding: 10px;
        text-align: center;
        font-size: 1.1em;
        background-color: #2c2c2c;
        border: 1px solid #555;
        border-radius: 8px;
        color: #e0e0e0;
    }
    .quantity-input:focus {
        outline: none;
        border-color: yellowgreen;
    }

    .btn-add-to-cart {
        flex-grow: 1; /* Button takes remaining space */
        padding: 10px 20px;
        font-size: 1.1em;
        font-weight: bold;
        background-color: yellowgreen;
        color: #121212;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-add-to-cart:hover {
        background-color: #d1ff52;
        transform: translateY(-2px);
    }

    /* Description Section */
    .product-description-box {
        margin-top: 15px;
    }
    .product-description-box h3 {
        font-size: 1.2rem;
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #444;
    }
    .product-description-box p {
        font-size: 1rem;
        color: #bbbbbb;
        line-height: 1.8;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .details-column {
            padding-left: 15px; /* default bootstrap padding */
            margin-top: 30px;
        }
        .product-card {
            padding: 20px;
        }
        .product-title {
            font-size: 2rem;
        }
        .product-price {
            font-size: 1.8rem;
        }
    }
</style>
{{-- <div class="small-container single-product mt-4">
    <div class="row">
        <div class="col-4">
            <section>
                <div id="">
                    <div id="slidingImage">
                        @if($produk->foto)
                            <img src="{{ asset('foto_produk/' . $produk->foto) }}" alt="{{ $produk->nama }}" style="max-height: 300px;">
                        @else
                            <p>Foto tidak tersedia</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        <div class="col-6">
            <p><a href="#">Kategori</a> / {{ ucfirst($produk->kategori) }}</p>
            <h2>{{ $produk->nama }}</h2>
            <h4>Rp {{ number_format($produk->harga, 0, ',', '.') }}</h4>

            <form action="{{ route('keranjang.tambah', $produk->id) }}" method="POST">
                @csrf
                <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" class="form-control w-25 mb-3" />
                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
            </form>
            <h3 class="mt-4">Detail Produk</h3>
            <hr>
            <p>{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

            <p><strong>Stok tersedia:</strong> {{ $produk->stok }}</p>

            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div> --}}

{{-- <div class="small-container single-product">
    <div class="row">
        <div class="col-md-6">
            @if ($produk->foto)
                 <img src="{{ asset('foto_produk/' . $produk->foto) }}" width="100%" class="product-img">
            @else
                 <img src="https://via.placeholder.com/500x500?text=Produk" width="100%" class="product-img">
            @endif
        </div>
        <div class="col-md-6 product-details">
            <p class="breadcrumb-custom">Produk / {{ $produk->kategori }}</p>
            <h1>{{ $produk->nama }}</h1>
            <h4 class="product-price">Rp{{ number_format($produk->harga) }}</h4>
            
            <form action="{{ route('keranjang.tambah', $produk->id) }}" method="POST" class="cart-form">
                @csrf
                <input type="number" name="jumlah" value="1" min="1" class="quantity-input">
                <button type="submit" class="btn-add-to-cart">Add To Cart</button>
            </form>
            
            <h3 class="details-heading">Detail Produk <i class="fa fa-indent"></i></h3>
            <p class="product-description">{{ $produk->deskripsi }}</p>
        </div>
    </div>
</div> --}}
<div class="product-view-container">
    <div class="product-card">
        <div class="row">
            {{-- KOLOM KIRI: GAMBAR --}}
            <div class="col-md-6 image-column">
                @if ($produk->foto)
                     <img src="{{ asset('foto_produk/' . $produk->foto) }}" alt="{{ $produk->nama }}">
                @else
                     <img src="https://via.placeholder.com/500x500?text=Produk" alt="Gambar produk tidak tersedia">
                @endif
            </div>

            {{-- KOLOM KANAN: DETAIL --}}
            <div class="col-md-6 details-column">
                <p class="product-breadcrumb">Produk / {{ $produk->kategori }}</p>
                <h1 class="product-title">{{ $produk->nama }}</h1>
                <p class="product-price">Rp{{ number_format($produk->harga) }}</p>
                
                {{-- --- BAGIAN INDIKATOR STOK --- --}}
                @if($produk->stok == 0)
                    <div class="stock-badge stock-habis">
                        <i class="fa fa-times-circle"></i> Stok Habis
                    </div>
                @elseif($produk->stok <= 5)
                    <div class="stock-badge stock-nipis">
                        <i class="fa fa-exclamation-circle"></i> Stok Menipis: Sisa {{ $produk->stok }}
                    </div>
                @else
                    <div class="stock-badge stock-aman">
                        <i class="fa fa-check-circle"></i> Stok Tersedia: {{ $produk->stok }}
                    </div>
                @endif

                <form action="{{ route('keranjang.tambah', $produk->id) }}" method="POST" class="product-actions-form">
                    @csrf
                    <input class="quantity-input" type="number" name="jumlah" value="1" min="1">
                    <button type="submit" class="btn-add-to-cart">
                        <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                    </button>
                </form>
                
                <div class="product-description-box">
                    <h3><i class="fa fa-indent"></i> Detail Produk</h3>
                    <p>{{ $produk->deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="small-container">
    <div class="row-2 row" style="color: greenyellow; justify-content: space-between;">
      <h2>Rekomendasi {{ ucfirst($produk->kategori) }}</h2>
      <a href="/sayuran">
        <p style="color: greenyellow;">More</p>
      </a>
    </div>
<div class="row">
        @foreach ($produkRekomendasi as $p)
        <div class="col-4">
            <a href="{{ route('produk.show', $p->id) }}">
                @if ($p->foto)
                    {{-- Gambar di rekomendasi juga dikasih efek kalau habis --}}
                    <img src="{{ asset('foto_produk/' . $p->foto) }}" alt="{{ $p->nama }}" 
                         style="width:100%; aspect-ratio: 1/1; object-fit:cover; {{ $p->stok == 0 ? 'filter: grayscale(100%); opacity: 0.6;' : '' }}">
                @else
                    <img src="https://via.placeholder.com/250x250?text=Tidak+ada+Foto" alt="Tidak ada foto">
                @endif
            </a>
            <h4>{{ $p->nama }}</h4>
            <p>Rp{{ number_format($p->harga, 0, ',', '.') }}</p>
            
            {{-- Indikator stok mini di rekomendasi --}}
            @if($p->stok == 0)
                <small style="color: #e57373;">Stok Habis</small>
            @endif
        </div>
        @endforeach
    </div>
</div>

@endsection
