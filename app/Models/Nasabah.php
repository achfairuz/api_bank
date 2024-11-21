<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = "nasabah";
    protected $primaryKey = 'id_nasabah';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'nomor_telepon',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ibu',
    ];
}
