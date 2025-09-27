<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomplainKunjungan extends Model
{
    use HasFactory;
    protected $table = 'komplain_kunjungan';
    protected $guarded = ['id'];

    public function jadwalTeknisi()
    {
        return $this->hasMany(JadwalTeknisi::class, 'id_komplain_kunjungan')->with('user');
    }
}
