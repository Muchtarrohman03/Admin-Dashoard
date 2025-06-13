<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
     use HasFactory;
     protected $primaryKey = 'service_id';
     protected $fillable = ['tanggal_masuk', 'owner','kendala','penggantian_part','tipe','serial_number'];
     public $incrementing = false; // <- WAJIB
     protected $keyType = 'string'; // <- WAJIB
     protected static function boot()
    {
            parent::boot();

            static::creating(function ($service) {
                // Ambil tanggal_masuk dan ubah ke format Ymd
                $date = \Carbon\Carbon::parse($service->tanggal_masuk)->format('Ymd');
                $year = \Carbon\Carbon::parse($service->tanggal_masuk)->year;

                // Ambil service terakhir di tanggal yang sama
                $last = DB::table('services')
                    ->whereDate('tanggal_masuk', $service->tanggal_masuk)
                    ->where('service_id', 'like', "SVC-$date-%")
                    ->orderBy('service_id', 'desc')
                    ->first();

                if ($last) {
                    // Ambil nomor terakhir dan tambahkan 1
                    $lastNumber = (int) substr($last->service_id, -4);
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }

                $sequence = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                $service->service_id = "SVC-$date-$sequence";
            });
    }
    public function getTanggalMasukFormattedAttribute()
    {
    return \Carbon\Carbon::parse($this->tanggal_masuk)->format('d-m-Y');
    }


}
