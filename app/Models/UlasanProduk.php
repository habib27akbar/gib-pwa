<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanProduk extends Model
{
    use HasFactory;
    protected $table = 'ulasan_produk';
    //protected $primaryKey = 'id_produk';
    protected $guarded = ['id'];
}
