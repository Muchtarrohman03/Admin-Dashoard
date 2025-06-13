<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Exports\ServicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Validation\ValidatesRequests;



class ServiceController extends Controller
{
    use ValidatesRequests;
public function index(Request $request)
{
    $query = Service::query();

    // Filter berdasarkan search
    if ($request->filled('search')) {
        $query->where('owner', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan waktu
    if ($request->filled('filter')) {
        $now = Carbon::now('Asia/Jakarta');
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        if ($request->filter === 'day') {
            $query->whereDate('created_at', $now->toDateString());
        } elseif ($request->filter === 'week') {
            $query->where('created_at', '>=', $now->copy()->startOfWeek()->toDateTimeString())
          ->where('created_at', '<=', $now->copy()->endOfWeek()->toDateTimeString());
        } elseif ($request->filter === 'month') {
            $query->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);
        }
    }

        $services = $query->paginate(12)
            ->appends($request->only(['search', 'filter']))
            ->withPath(route('services.index')); // agar path selalu ke /services

    return view('services.index', compact('services'));
}

public function admin(Request $request){
        $query = Service::query();

    // Filter berdasarkan search
    if ($request->filled('search')) {
        $query->where('owner', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan waktu
    if ($request->filled('filter')) {
        $now = Carbon::now('Asia/Jakarta');
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        if ($request->filter === 'day') {
            $query->whereDate('created_at', $now->toDateString());
        } elseif ($request->filter === 'week') {
            $query->where('created_at', '>=', $now->copy()->startOfWeek()->toDateTimeString())
          ->where('created_at', '<=', $now->copy()->endOfWeek()->toDateTimeString());
        } elseif ($request->filter === 'month') {
            $query->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);
        }
    }

        $services = $query->paginate(12)
            ->appends($request->only(['search', 'filter']))
            ->withPath(route('services.index')); // agar path selalu ke /services
    return view('services.admin-services', compact('services'));
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
    public function store(Request $request){

        $this->validate($request, [
            'tanggal_masuk' => 'required|date',
            'owner' => 'required',
            'kendala' => 'required',
            'penggantian_part' => 'required',
            'tipe' => 'required',
            'serial_number' => 'required|numeric',

        ]);



        Service::create([
            'tanggal_masuk' => $request->tanggal_masuk,
            'owner' => $request->owner,
            'kendala' => $request->kendala,
            'penggantian_part' => $request->penggantian_part,
            'tipe' => $request->tipe,
            'serial_number' => $request->serial_number,

        ]);
        return redirect()->route('admin.services')->with('success', 'Data Servis Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, service $service)
    {
        $validated = $request->validate([
            'owner' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
            'kendala' => 'nullable|string',
            'penggantian_part' => 'nullable|string',
            'tipe' => 'nullable|string',
            'serial_number' => 'nullable|numeric',
        ]);

        // Pertahankan nilai lama jika tidak ada perubahan
        $validated['owner'] = $validated['owner'] ?? $service->owner;
        $validated['tanggal_masuk'] = $validated['tanggal_masuk'] ?? $service->tanggal_masuk;
        $validated['kendala'] = $validated['kendala'] ?? $service->kendala;
        $validated['penggantian_part'] = $validated['penggantian_part'] ?? $service->penggantian_part;
        $validated['tipe'] = $validated['tipe'] ?? $service->tipe;
        $validated['serial_number'] = $validated['serial_number'] ?? $service->serial_number;

        $service->update($validated);
        return redirect()->route('admin.services')->with('success', 'Data Servis Telah Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(service $service)
    {
        $service->delete();
         return redirect()->route('admin.services')->with('success', 'Data Servis Telah Dihapus!');
    }

   public function export(Request $request)
    {
        return Excel::download(new ServicesExport($request), 'data-servis.xlsx');
    }

}
