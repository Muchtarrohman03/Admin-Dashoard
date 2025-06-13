<?php

use Carbon\Carbon;
use App\Models\Order;

if (!function_exists('generateInvoice')) {
    function generateInvoice($tanggal)
    {
        $tgl = Carbon::parse($tanggal)->format('dmy');
        do {
            $rand = str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
            $invoice = "INV-{$tgl}-{$rand}";
        } while (Order::where('invoice', $invoice)->exists());

        return $invoice;
    }
}
