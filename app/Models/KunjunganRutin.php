<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KunjunganRutin extends Model
{
    use HasFactory;
    protected $table = 'kunjungan_rutin';
    protected $guarded = ['id'];

    public function teknisis(): HasMany
    {
        return $this->hasMany(KunjunganTeknisi::class, 'id_kunjungan_rutin');
    }
}
