<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Validation\ValidatesRequests;


class ProductController extends Controller
{
     use ValidatesRequests;
    public function index()
    {
        $products = Product::with('specification')->paginate(12);
        $product = Product::with('images');

        // Jika request dari API (application/json), kirimkan JSON response
        if (request()->wantsJson()) {
            return response()->json($products);
        }

        // Jika bukan, tampilkan view
        return view('product.index', compact('products'));
    }
    public function admin()
    {
        $products = Product::with('specification')->paginate(12);
        $product = Product::with('images');
        return view('product.admin-product', compact('products'));
    }

    // public function create(){
    //     return view('product.create');
    // }
    public function preview($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product.preview', compact('product'));
    }
    
   public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'harga'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'image'         => 'required|image|mimes:png,jpg,jpeg',
            'description'   => 'required|string|max:600',
            'specification' => 'nullable|array',
            'images.*'      => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        // 2. Simpan gambar utama
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        // 3. Simpan data produk melalui relasi user → products
        $product = $request->user()->products()->create([
            'title'       => $validated['title'],
            'harga'       => str_replace('.', '', $validated['harga']),
            'stock'       => $validated['stock'],
            'description' => $validated['description'],
            'image'       => 'products/' . $image->hashName(),
        ]);

        // 4. Debug: apakah produk tersimpan?
        if (!$product) {
            dd('Produk gagal disimpan');
        }

        // 5. Simpan carousel image (jika ada)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $carouselImage) {
                $carouselImage->storeAs('public/carousel', $carouselImage->hashName());

                $product->images()->create([
                    'image' => 'carousel/' . $carouselImage->hashName(),
                ]);
            }
        }

        // 6. Simpan spesifikasi (jika ada)
        if (!empty($validated['specification'])) {
            $product->specification()->create([
                'data' => $validated['specification'],
            ]);
        }

        // 7. Redirect sukses
        return redirect()->route('admin.product')->with('success', 'Produk berhasil ditambahkan.');
    }





    // public function edit(Product $product){
    //      return view('product.edit', compact('product'));
    // }

    public function update(Request $request, Product $product)
    {
        /* 1. Pastikan user berhak mengubah produk ini */
       // abort_if($request->user()->id !== $product->user_id, 403, 'Tidak diizinkan');

        /* 2. Validasi input */
        $validated = $request->validate([
            'title'         => 'nullable|string|max:255',
            'harga'         => 'nullable|numeric',
            'stock'         => 'nullable|numeric',
            'description'   => 'nullable|string|max:600',
            'image'         => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'images.*'      => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'specification' => 'nullable|array',
        ]);

        /* 3. Set nilai default jika field tidak diisi */
        $data = [
            'title'       => $validated['title']       ?? $product->title,
            'harga'       => $validated['harga']       ?? $product->harga,
            'stock'       => $validated['stock']       ?? $product->stock,
            'description' => $validated['description'] ?? $product->description,
        ];

        /* 4. Perbarui gambar utama (jika ada) */
        if ($request->hasFile('image')) {
            if ($product->image && $product->image !== 'noimage.png') {
                Storage::disk('public')->delete($product->image);
            }
            $file = $request->file('image');
            $file->storeAs('public/products', $file->hashName());
            $data['image'] = 'products/' . $file->hashName();
        }

        /* 5. Simpan perubahan data dasar produk */
        $product->update($data);

        /* 6. Tambah gambar carousel baru (jika ada) */
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $carousel) {
                $carousel->storeAs('public/carousel', $carousel->hashName());
                $product->images()->create([
                    'image' => 'carousel/' . $carousel->hashName(),
                ]);
            }
        }

        /* 7. Perbarui / buat spesifikasi (kolom JSON) */
        if ($request->filled('specification')) {
            $product->specification()->updateOrCreate(
                ['product_id' => $product->id],
                ['data' => $validated['specification']]   // simpan sebagai JSON
            );
        }

        /* 8. Redirect sukses */
        return redirect()
            ->route('admin.product')
            ->with('success', 'Produk berhasil diperbarui.');
    }

public function destroy(Request $request, Product $product)
{
    // 1. Pastikan user login adalah pemilik produk
    abort_if($request->user()->id !== $product->user_id, 403, 'Tidak diizinkan menghapus produk ini');

    // 2. Hapus gambar utama jika bukan gambar default
    if ($product->image && $product->image !== 'noimage.png') {
        Storage::disk('public')->delete($product->image);
    }

    // 3. Hapus semua gambar carousel terkait
    foreach ($product->images as $image) {
        Storage::disk('public')->delete($image->image);
        $image->delete(); // hapus record-nya
    }

    // 4. Hapus spesifikasi (relasi one-to-one)
    if ($product->specification) {
        $product->specification->delete();
    }

    // 5. Hapus produk itu sendiri
    $product->delete();

    // 6. Redirect
    return redirect()->route('admin.product')->with('success', 'Produk berhasil dihapus.');
}

}
