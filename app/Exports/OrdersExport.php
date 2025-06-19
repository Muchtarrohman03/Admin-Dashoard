<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $data = [];

        // Ambil semua order beserta produk terkaitnya
        $orders = Order::with('products')->get();

        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $kuantitas = $product->pivot->kuantitas ?? 1;
                $harga_satuan = $product->harga ?? 0;
                $subtotal = $kuantitas * $harga_satuan;

                $data[] = [
                    'Order ID'           => $order->id,
                    'Pembeli'            => $order->pembeli,
                    'Tanggal Pembelian'  => $order->tanggal_pembelian,
                    'Produk'             => $product->title,
                    'Kuantitas'          => $kuantitas,
                    'Harga Satuan'       => $harga_satuan,
                    'Subtotal'           => $subtotal,
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No.',
            'Pembeli',
            'Tanggal Pembelian',
            'Produk',
            'Kuantitas',
            'Harga Satuan',
            'Subtotal',
        ];
    }
}

