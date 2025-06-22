<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $orders = Order::with('products')->paginate(10); // 10 data per halaman
        return view('orders.index', compact('orders', 'products'));
    }
    public function admin()
    {
        $products = Product::all();
        $orders = Order::with('products')->paginate(10); // 10 data per halaman
        return view('orders.admin-orders', compact('orders', 'products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* ===================== 1. VALIDASI ===================== */
        $validated = $request->validate([
            'pembeli'            => 'required|string|max:255',
            'tanggal_pembelian'  => 'required|date',
            'email'              => 'required|email|max:255',
            'telepon'            => 'required|string|max:20',
            'alamat_pengiriman'  => 'required|string|max:500',

            // array produk wajib ada
            'products'           => ['required','array', function ($attribute, $value, $fail) {
                if (!collect($value)->contains('selected', 1)) {
                    $fail('Pilih setidaknya satu produk.');
                }
            }],

            // aturan per item
            'products.*.selected'  => 'required_with:products.*.kuantitas|in:1',
            'products.*.kuantitas' => 'required_if:products.*.selected,1|integer|min:1|max:1000',
        ]);

        /* ===================== 2. VALIDASI stock ===================== */
        foreach ($request->products ?? [] as $productId => $p) {
            if (!empty($p['selected']) && isset($p['kuantitas'])) {
                $stock = Product::where('id', $productId)->value('stock') ?? 0;
                if ($p['kuantitas'] > $stock) {
                    return back()
                        ->withErrors(["products.$productId.kuantitas" => "stock hanya $stock, tidak cukup."])
                        ->withInput();
                }
            }
        }

        /* ===================== 3. TRANSAKSI ===================== */
        DB::transaction(function () use ($request, $validated) {

            /* -- 3a. Buat Order dengan invoice otomatis -- */
            $order = $request->user()->orders()->create([
                'invoice'           => generateInvoice($validated['tanggal_pembelian']),
                'tanggal_pembelian' => $validated['tanggal_pembelian'],
                'pembeli'           => $validated['pembeli'],
                'email'             => $validated['email'],
                'telepon'           => $validated['telepon'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
            ]);

            /* -- 3b. Susun data pivot & kurangi stock -- */
            $pivotData = collect($request->products)
                ->filter(fn ($item) => !empty($item['selected']))
                ->mapWithKeys(function ($item, $productId) {
                    return [$productId => ['kuantitas' => $item['kuantitas']]];
                })
                ->toArray();

            // attach pivot
            $order->products()->attach($pivotData);

            // kurangi stock tiap produk
            foreach ($pivotData as $productId => $pivot) {
                Product::where('id', $productId)
                    ->decrement('stock', $pivot['kuantitas']);
            }
        });

        return redirect()->route('admin.orders')->with('success', 'Order berhasil dibuat dan stok produk telah diperbarui.');
    }




    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
        /* ========== 1. VALIDASI DASAR ========== */
        $validator = Validator::make($request->all(), [
            'pembeli'            => 'required|string|max:255',
            'tanggal_pembelian'  => 'required|date',
            'email'              => 'required|email|max:255',
            'telepon'            => 'required|string|max:20',
            'alamat_pengiriman'  => 'required|string|max:500',

            'products'           => 'required|array',
            'products.*.selected'  => 'required_with:products.*.kuantitas|in:1',
            'products.*.kuantitas' => 'required_if:products.*.selected,1|integer|min:1|max:1000',
        ]);

        // pastikan minimal satu produk dipilih
        $validator->after(function ($v) use ($request) {
            if (!collect($request->products)->contains('selected', 1)) {
                $v->errors()->add('products', 'Pilih setidaknya satu produk.');
            }
        });

        $validated = $validator->validate(); // akan redirect jika gagal

        /* ========== 2. AMBIL ORDER & DATA LAMA ========== */
        $order = Order::with('products')->findOrFail($id);
        $oldPivot = $order->products->pluck('pivot.kuantitas', 'id');  // [product_id => qty_lama]

        /* ========== 3. SUSUN DATA BARU & CEK stock ========== */
        $newPivot = collect($validated['products'])
            ->filter(fn ($item) => ($item['selected'] ?? null) == 1)
            ->mapWithKeys(fn ($item, $productId) => [
                $productId => ['kuantitas' => $item['kuantitas']]
            ])
            ->toArray();                                               // [product_id => ['kuantitas'=>qty_baru]]

        // --- Validasi stock: diff + stock tersedia ---
        foreach ($newPivot as $productId => $item) {
            $oldQty = $oldPivot[$productId] ?? 0;
            $diff   = $item['kuantitas'] - $oldQty; // positif = tambah kuantitas
            if ($diff > 0) {
                $stockTersedia = Product::where('id', $productId)->value('stock');
                if ($diff > $stockTersedia) {
                    return back()
                        ->withErrors(["products.$productId.kuantitas" =>
                            "stock tidak cukup. Sisa $stockTersedia, penambahan $diff melebihi stock."])
                        ->withInput();
                }
            }
        }

        /* ========== 4. TRANSAKSI ========== */
        DB::transaction(function () use ($order, $validated, $oldPivot, $newPivot) {

            /* 4a. Update data order */
            $order->update([
                'pembeli'           => $validated['pembeli'],
                'tanggal_pembelian' => $validated['tanggal_pembelian'],
                'email'             => $validated['email'],
                'telepon'           => $validated['telepon'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
            ]);

            /* 4b. Kembalikan stock lama */
            foreach ($oldPivot as $productId => $qtyLama) {
                Product::where('id', $productId)->increment('stock', $qtyLama);
            }

            /* 4c. Sync pivot dgn data baru */
            $order->products()->sync($newPivot);

            /* 4d. Kurangi stock berdasarkan data baru */
            foreach ($newPivot as $productId => $item) {
                Product::where('id', $productId)->decrement('stock', $item['kuantitas']);
            }
        });

        return redirect()
            ->route('admin.orders')
            ->with('success', 'Data Pesanan berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            // Ambil pesanan dengan relasi produk
            $order = Order::with('products')->findOrFail($id);

            // Kembalikan stock ke masing-masing produk
            foreach ($order->products as $product) {
                $qty = $product->pivot->kuantitas;
                Product::where('id', $product->id)->increment('stock', $qty);
            }

            // Hapus relasi di pivot
            $order->products()->detach();

            // Hapus order
            $order->delete();
        });

        return redirect()
            ->route('admin.orders')
            ->with('success', 'Data Pesanan berhasil dihapus !');
    }
    
    public function export()
    {
        return Excel::download(new OrdersExport, 'Laporan Pesanan.xlsx');
    }
}
