<?php

namespace App\Models;
use App\Models\Product;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory,HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_karyawan', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getShortNameAttribute()
    {
        $parts = explode(' ', $this->name);
        $short = $parts[0];

        if (count($parts) > 1) {
            $short .= ' ' . Str::upper(Str::substr($parts[1], 0, 1)) . '.';
        }

        return $short;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class); // default: foreign key 'user_id'
    }
}
