<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        protected $fillable = [
        'invoice',
        'tanggal_pembelian',
        'pembeli',
        'email',
        'telepon',
        'alamat_pengiriman'
    ];
        protected $casts = [
            'tanggal_pembelian' => 'date'
        ];

    // Tambahkan ini untuk memastikan invoice unik
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->invoice = $model->invoice ?? generateInvoice($model->tanggal_pembelian);
        });
    }

    public function products()
    {
    return $this->belongsToMany(Product::class)->withPivot('kuantitas')->withTimestamps();
    }
}
