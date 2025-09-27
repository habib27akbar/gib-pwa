<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;
    protected $table = 'workshop';
    protected $primaryKey = 'id_workshop';
    protected $guarded = ['id_workshop'];
}
