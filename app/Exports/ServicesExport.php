<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;  

class ServicesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /** Ambil data dasar */
    public function collection()
    {
        $query = Service::with('user');  // <-- eager-load relasi user

        // --- filter search
        if ($this->request->filled('search')) {
            $query->where('owner', 'like', '%' . $this->request->search . '%');
        }

        // --- filter waktu
        if ($this->request->filled('filter')) {
            $now = Carbon::now();
            if ($this->request->filter === 'day') {
                $query->whereDate('created_at', $now->toDateString());
            } elseif ($this->request->filter === 'week') {
                $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
            } elseif ($this->request->filter === 'month') {
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
            }
        }

        // cukup get() saja; kolomnya nanti dirakit di map()
        return $query->get();
    }

    /** Susun setiap baris */
    public function map($service): array
    {
        return [
            $service->service_id,
            $service->owner,
            // contoh: ubah tanggal ke format Excel agar terbaca sebagai date
            Date::dateTimeToExcel(Carbon::parse($service->tanggal_masuk)),
            $service->kendala,
            $service->penggantian_part,
            $service->tipe,
            $service->serial_number,
            // kolom tambahan: nama user penginput
            optional($service->user)->name ?? '-',   // hindari null
        ];
    }

    /** Judul kolom */
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
            'User Penginput', // <-- heading baru
        ];
    }
}
