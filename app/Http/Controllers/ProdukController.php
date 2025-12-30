<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $produk = Produk::all();
    //     return view('produk.index', compact('produk'));


    // }

    public function index(Request $request)
{
    $query = Produk::query();

    // Pencarian berdasarkan nama/kategori
    if ($request->filled('search')) {
        $search = str_replace(' ', '%', $request->search);
        $query->where('nama', 'like', '%' . $search . '%')
              ->orWhere('kategori', 'like', '%' . $search . '%');
    }

    // Filter (sorting)
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'harga_termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'stok_terendah':
                $query->orderBy('stok', 'asc');
                break;
            case 'stok_tertinggi':
                $query->orderBy('stok', 'desc');
                break;
            default:
                $query->latest();
        }
    } else {
        $query->latest(); // Default: urutkan berdasarkan terbaru
    }

    $produk = $query->get(); // Pakai pagination
    return view('produk.index', compact('produk'));
}

    public function semua(Request $request)
{
    $query = Produk::query();

    // Pencarian
    if ($request->filled('search')) {
        $search = str_replace(' ', '%', $request->search); // bikin pencarian lebih fleksibel
        $query->where('nama', 'like', '%' . $search . '%')
            ->orWhere('kategori', 'like', '%' . $search . '%');;
    }
    

    // Sorting
    if ($request->filled('sort')) {
        if ($request->sort === 'termahal') {
            $query->orderBy('harga', 'desc');
        } elseif ($request->sort === 'termurah') {
            $query->orderBy('harga', 'asc');
        } else {
            $query->latest(); // Default: terbaru
        }
    } else {
        $query->latest(); // Default sorting: terbaru
    }

    $produkTerbaru = $query->paginate(12); // PAGINATION DI SINI

    return view('produk.semuaproduk', compact('produkTerbaru'));
}

public function kategoriSayur(Request $request)
{
    // Membuat query dasar untuk kategori sayur
    $query = Produk::where('kategori', 'sayur');

    // Filter berdasarkan harga
    if ($request->filled('sort')) {
        if ($request->sort == 'termurah') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort == 'termahal') {
            $query->orderBy('harga', 'desc');
        }
    }

    // Search produk berdasarkan nama
    if ($request->filled('search')) {
        $search = str_replace(' ', '%', $request->search); // fleksibel terhadap spasi
        $query->where('nama', 'like', '%' . $search . '%');
    }

    // Ambil produk yang sudah difilter dan diurutkan
    $produkTerbaru = $query->latest()->paginate(12);

    return view('produk.sayuran', compact('produkTerbaru'));
}

public function kategoriBuah(Request $request)
{
    // Membuat query dasar untuk kategori buah
    $query = Produk::where('kategori', 'buah');

    // Filter berdasarkan harga
    if ($request->filled('sort')) {
        if ($request->sort == 'termurah') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort == 'termahal') {
            $query->orderBy('harga', 'desc');
        }
    }

    // Search produk berdasarkan nama
    if ($request->filled('search')) {
        $search = str_replace(' ', '%', $request->search); // fleksibel terhadap spasi
        $query->where('nama', 'like', '%' . $search . '%');
    }

    // Ambil produk yang sudah difilter dan diurutkan
    $produkTerbaru = $query->latest()->paginate(12);

    return view('produk.buahan', compact('produkTerbaru'));
}

public function kategoriRempah(Request $request)
{
    // Membuat query dasar untuk kategori buah
    $query = Produk::where('kategori', 'rempah');

    // Filter berdasarkan harga
    if ($request->filled('sort')) {
        if ($request->sort == 'termurah') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort == 'termahal') {
            $query->orderBy('harga', 'desc');
        }
    }

    // Search produk berdasarkan nama
    if ($request->filled('search')) {
        $search = str_replace(' ', '%', $request->search); // fleksibel terhadap spasi
        $query->where('nama', 'like', '%' . $search . '%');
    }

    // Ambil produk yang sudah difilter dan diurutkan
    $produkTerbaru = $query->latest()->paginate(12);

    return view('produk.rempahan', compact('produkTerbaru'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required|string',
            'kategori' => 'required|in:sayur,buah,rempah',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $namaFile = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto_produk'), $namaFile);
            $validasi['foto'] = $namaFile;
        }

        Produk::create($validasi);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $produk = Produk::findOrFail($id);
        $produkRekomendasi = Produk::where('kategori', $produk->kategori)
                            ->where('id', '!=', $produk->id)
                            ->latest()
                            ->take(4)
                            ->get();

    return view('produk.show', compact('produk', 'produkRekomendasi'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validasi = $request->validate([
            'nama' => 'required|string',
            'kategori' => 'required|in:sayur,buah,rempah',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $produk = Produk::findOrFail($id);
    
        // Handle upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($produk->foto && file_exists(public_path('foto_produk/' . $produk->foto))) {
                unlink(public_path('foto_produk/' . $produk->foto));
            }
    
            $namaFile = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto_produk'), $namaFile);
            $validasi['foto'] = $namaFile;
        }
    
        $produk->update($validasi);
    
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $produk = Produk::findOrFail($id);

    // Hapus file foto jika ada
    if ($produk->foto && file_exists(public_path('foto_produk/' . $produk->foto))) {
        unlink(public_path('foto_produk/' . $produk->foto));
    }

    $produk->delete();  

    return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    
}
