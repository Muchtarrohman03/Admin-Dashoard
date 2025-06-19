<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class Dashboardcontroller extends Controller
{
    //fungsi index
    public function index()
    {
        $data = [
            'jmlProduk' => Product::count(),
            'jmlServis' => Service::count(),
            'jmlPesanan' => Order::count(),
            'jmlUser' => User::count(),
        ];
        return view('dashboard', compact('data'));
    }
    public function getServiceChartData()
    {
        Carbon::setLocale('id'); // <- ini untuk set bahasa Indonesia

        $months = [];
        $serviceCounts = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            // Gunakan translatedFormat agar nama bulan Bahasa Indonesia
            $months[] = $month->translatedFormat('F');

            $count = Service::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $serviceCounts[] = $count;
        }

        return response()->json([
            'labels' => $months,
            'data' => $serviceCounts,
        ]);
    }
    public function getProductStockChartData()
    {
        $products = Product::select('title', 'stock')->get();

        return response()->json([
            'labels' => $products->pluck('title'),
            'data' => $products->pluck('stock'),
        ]);
    }

    public function getOrderChartData()
    {
        Carbon::setLocale('id');

        $months = [];
        $orderCounts = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('F');

            $count = Order::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();

            $orderCounts[] = $count;
        }

        return response()->json([
            'labels' => $months,
            'data' => $orderCounts,
        ]);
    }
}
