@extends('layout/aplikasi')

@section('konten')
<style>
    .produk-page {
        max-width: 1000px;
        margin: 40px auto;
        background-color: #2a2a2a;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.5);
        color: #e0e0e0;
        font-family: Arial, sans-serif;
    }

    .produk-page h2 {
        text-align: center;
        margin-bottom: 25px;
        color: yellowgreen;
    }

    .produk-page .alert {
        padding: 12px 18px;
        background-color: #3a3a3a;
        color: yellowgreen;
        border-left: 4px solid yellowgreen;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .produk-page .btn-tambah {
        display: inline-block;
        background-color: yellowgreen;
        color: #1e1e1e;
        padding: 10px 20px;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }

    .produk-page .btn-tambah:hover {
        background-color: #b2ff59;
    }

    .produk-page table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .produk-page th, 
    .produk-page td {
        padding: 12px;
        border: 1px solid #444;
        text-align: center;
    }

    .produk-page th {
        background-color: #333;
        color: yellowgreen;
    }

    .produk-page td {
        background-color: #2b2b2b;
    }

    .produk-page img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .produk-page .aksi {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .produk-page .aksi button,
    .produk-page .aksi a {
        padding: 6px 14px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-decoration: none;
        color: #fff;
    }

    .produk-page .aksi a {
        background-color: #ffc107;
        color: #1e1e1e;
    }

    .produk-page .aksi a:hover {
        background-color: #e0a800;
    }

    .produk-page .aksi button {
        background-color: #e74c3c;
    }

    .produk-page .aksi button:hover {
        background-color: #c0392b;
    }

    .form-filter-wrapper {
    display: flex;
    gap: 10px;
    margin: 20px 0;
    align-items: center;
}

.form-filter-wrapper input[type="text"],
.form-filter-wrapper select,
.form-filter-wrapper button {
    height: 36px;
    padding: 0 12px;
    border-radius: 6px;
    border: 1px solid yellowgreen;
    font-size: 14px;
    box-sizing: border-box;
}

.form-filter-wrapper input[type="text"],
.form-filter-wrapper select {
    width: 180px;
    background-color: #fdfdfd;
    color: #333;
}

.form-filter-wrapper button {
    background-color: yellowgreen;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.2s ease;
    border: none;
}

.form-filter-wrapper button:hover {
    background-color: #d9d9d9;
    color: black;
}
</style>

<div class="produk-page">
    <h2>Daftar Produk</h2>

    <form method="GET" action="{{ route('produk.index') }}" class="form-filter-wrapper">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk...">
        <button type="submit">Cari</button>
        <div style="width: 800%" class="kos"></div>
        <select name="sort" onchange="this.form.submit()">
            <option value="">Urutkan</option>
            <option value="harga_termurah" {{ request('sort') === 'harga_termurah' ? 'selected' : '' }}>Harga Termurah</option>
            <option value="harga_termahal" {{ request('sort') === 'harga_termahal' ? 'selected' : '' }}>Harga Termahal</option>
            <option value="stok_terendah" {{ request('sort') === 'stok_terendah' ? 'selected' : '' }}>Stok Terendah</option>
            <option value="stok_tertinggi" {{ request('sort') === 'stok_tertinggi' ? 'selected' : '' }}>Stok Tertinggi</option>
        </select>
    </form>
    

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('produk.create') }}" class="btn-tambah">+ Tambah Produk</a>

    @if ($produk->isEmpty())
        <div class="alert">Belum ada produk yang ditambahkan.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $index => $produk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($produk->foto)
                                <img src="{{ asset('foto_produk/' . $produk->foto) }}" alt="Foto Produk">
                            @else
                                <span style="color: #888">-</span>
                            @endif
                        </td>
                        <td>{{ $produk->nama }}</td>
                        <td>{{ ucfirst($produk->kategori) }}</td>
                        <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>
    @if($produk->stok == 0)
        <span style="background-color: #d9534f; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.85em;">
            Habis!
        </span>
    @elseif($produk->stok <= 5)
        <span style="background-color: #f0ad4e; color: black; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.85em;">
            {{ $produk->stok }} (Menipis)
        </span>
    @else
        <span style="background-color: #5cb85c; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.85em;">
            {{ $produk->stok }} (Aman)
        </span>
    @endif
</td>
                        <td>{{ $produk->deskripsi }}</td>
                        <td>
                            <div class="aksi">
                                <a href="{{ route('produk.edit', $produk->id) }}">Edit</a>
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    @endif
</div>
@endsection
