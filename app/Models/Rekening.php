<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;
    public $timestamps = false;


    // Tentukan nama tabel jika tidak menggunakan konvensi penamaan default
    protected $table = 'rekening';
    protected $primaryKey = 'id_rekening';

    // Tentukan kolom-kolom yang bisa diisi
    protected $fillable = [
        'no_rekening',
        'saldo',
    ];



    // Relasi dengan model Nasabah (banyak rekening dimiliki oleh satu nasabah)
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id_nasabah');
    }

    public function transaksiAsal()
    {
        return $this->hasMany(Transaksi::class, 'id_rekening', 'id_rekening');
    }

    public function transaksiTujuan()
    {
        return $this->hasMany(Transaksi::class, 'rekening_tujuan', 'id_rekening');
    }
}
