<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModAlamat extends Model
{
    use HasFactory;
    protected $table = 'mod_alamat';
    protected $primaryKey = 'id_alamat';
    protected $guarded = ['id_alamat'];
}
