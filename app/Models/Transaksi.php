<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan konvensi penamaan default
    public $timestamps = false;
    protected $table = 'transaksi';

    // Tentukan kolom-kolom yang bisa diisi
    protected $fillable = [
        'id_rekening',
        'rekening_tujuan',
        'jumlah_transaksi',
        'jenis_transaksi'
    ];

    // Relasi dengan model Rekening (satu rekening melakukan banyak transaksi)
    public function rekeningAsal()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening', 'id_rekening');
    }

    // Relasi dengan model Rekening untuk rekening tujuan (misalnya dalam kasus transfer)
    public function rekeningTujuan()
    {
        return $this->belongsTo(Rekening::class, 'rekening_tujuan', 'id_rekening');
    }
}
