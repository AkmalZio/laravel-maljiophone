<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi mass-assignment
     */
    protected $fillable = [
        'user_id',
        'produk_id',
        'quantity',
        'shipping_method', // tambahkan ini
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}