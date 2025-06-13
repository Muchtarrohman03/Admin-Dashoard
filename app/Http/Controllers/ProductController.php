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
        //dd($request->all());
        $this->validate($request, [
            'title' => 'required',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:png,jpg',
            'specification' => 'required|array', // validasi bahwa harus array
        ]);

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'title' => $request->title,
            'harga' => str_replace('.', '', $request->harga),
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => 'products/' . $image->hashName(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $carouselImage) {
                $fileName = $carouselImage->hashName();
                $carouselImage->storeAs('public/carousel', $fileName);

                $product->images()->create([
                    'image' => 'carousel/' . $fileName,
                ]);
            }
        }

        // Simpan semua spesifikasi sebagai JSON dalam kolom `data`
        $product->specification()->create([
            'data' => $request->specification, // ini array, Laravel otomatis simpan sebagai JSON
        ]);

        return redirect()->route('admin.product')->with('success', 'Produk berhasil ditambahkan.');
    }


    // public function edit(Product $product){
    //      return view('product.edit', compact('product'));
    // }

public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'stock' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Update produk utama
        $validated['title'] = $validated['title'] ?? $product->title;
        $validated['harga'] = $validated['harga'] ?? $product->harga;
        $validated['stock'] = $validated['stock'] ?? $product->stock;
        $validated['description'] = $validated['description'] ?? $product->description;

        if ($request->hasFile('image')) {
            if ($product->image && $product->image !== 'noimage.png') {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('', 'public');
        } else {
            $validated['image'] = $product->image;
        }

        $product->update($validated);

        // Upload carousel image baru
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $carousel) {
                $path = $carousel->store('', 'public');
                $product->images()->create(['image' => $path]);
            }
        }


        // Update/Replace spesifikasi
        if ($request->filled('specification')) {
            $data = $request->input('specification')[0]; // One to one
            $product->specification()->updateOrCreate(
                ['product_id' => $product->id],
                ['key' => $data['key'], 'value' => $data['value']]
            );
        }

        return redirect()->route('admin.product')->with('success', 'Produk berhasil diperbarui.');
        
    }

    public function destroy(Product $product){
        if($product->image !== 'noimage.png'){
            Storage::disk('local')->delete('public/'. $product->image);
        }
        $product->delete();
        return redirect()->route('admin.product')->with('success', 'Produk berhasil dihapus.');
    }

}
