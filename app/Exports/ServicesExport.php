<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServicesExport implements FromCollection, WithHeadings
{
     protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $query = Service::query();

        // Filter berdasarkan search
        if ($this->request->filled('search')) {
            $query->where('owner', 'like', '%' . $this->request->search . '%');
        }

        // Filter berdasarkan waktu
        if ($this->request->filled('filter')) {
            $now = Carbon::now();

            if ($this->request->filter === 'day') {
                $query->whereDate('created_at', $now->toDateString());
            } elseif ($this->request->filter === 'week') {
                $query->whereBetween('created_at', [
                    $now->copy()->startOfWeek(), $now->copy()->endOfWeek()
                ]);
            } elseif ($this->request->filter === 'month') {
                $query->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year);
            }
        }

        return $query->select(
            'service_id',
            'owner',
            'tanggal_masuk',
            'kendala',
            'penggantian_part',
            'tipe',
            'serial_number'
        )->get();
    }
    public function headings(): array
    {
        return [
            'Service ID',
            'Owner',
            'Tanggal Masuk',
            'Kendala',
            'Penggantian Part',
            'Tipe',
            'Serial Number',
        ];
    }
    
}
