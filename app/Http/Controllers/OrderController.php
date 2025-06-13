<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    $validated = $request->validate([
        'pembeli' => 'required|string|max:255',
        'tanggal_pembelian' => 'required|date',
        'email' => 'required|email|max:255',
        'telepon' => 'required|string|max:20',
        'alamat_pengiriman' => 'required|string|max:500',
        'products' => ['required', 'array', function ($attribute, $value, $fail) {
            if (!collect($value)->contains('selected', 1)) {
                $fail('Pilih setidaknya satu produk.');
            }
        }],
        'products.*.selected' => 'required_with:products.*.kuantitas|in:1',
        'products.*.kuantitas' => 'required_if:products.*.selected,1|integer|min:1|max:1000',
    ]);

    DB::transaction(function () use ($request) {
        $order = Order::create($request->only([
            'tanggal_pembelian',
            'pembeli',
            'email',
            'telepon',
            'alamat_pengiriman'
        ]));

        $products = collect($request->products)
            ->filter(fn($p) => !empty($p['selected']))
            ->mapWithKeys(fn($p, $id) => [$id => ['kuantitas' => $p['kuantitas']]]);

        $order->products()->attach($products);
    });

    return redirect()->route('orders.index')->with('success', 'Order berhasil dibuat.');
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
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
