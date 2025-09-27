<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKomplainTeknisi extends Model
{
    use HasFactory;
    protected $table = 'laporan_komplain_teknisi';
    protected $guarded = ['id'];
}
