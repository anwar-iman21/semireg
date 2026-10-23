<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'kode_tiket', 'nama', 'email', 'no_hp', 'kategori', 'nim', 'institusi',
    ];
}
