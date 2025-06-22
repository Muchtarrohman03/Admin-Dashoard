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

        // Ambil semua order beserta relasi product dan user
        $orders = Order::with(['products', 'user'])->get();

        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $kuantitas = $product->pivot->kuantitas ?? 1;
                $harga_satuan = $product->harga ?? 0;
                $subtotal = $kuantitas * $harga_satuan;

                $data[] = [
                    'Nomor Invoice'           => $order->invoice,
                    'Pembeli'            => $order->pembeli,
                    'Tanggal Pembelian'  => $order->tanggal_pembelian,
                    'Produk'             => $product->title,
                    'Kuantitas'          => $kuantitas,
                    'Harga Satuan'       => $harga_satuan,
                    'Subtotal'           => $subtotal,
                    'Penginput'     => $order->user->name ?? '-', // nama user
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Nomor Invoice',
            'Pembeli',
            'Tanggal Pembelian',
            'Produk',
            'Kuantitas',
            'Harga Satuan',
            'Subtotal',
            'Penginput',
        ];
    }
}

