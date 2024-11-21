<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $table = 'api_key';

    // Tentukan kolom-kolom yang bisa diisi
    protected $fillable = [
        'api_key',
        'app_name'
    ];
}
