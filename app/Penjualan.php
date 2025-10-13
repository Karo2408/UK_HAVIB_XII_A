<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'TanggalPenjualan',
        'TotalHarga',
        'TotalDiskon',
        'PelangganID',
        'UserID',
        'Metode',
        'Status',
        'JumlahBayar',
        'Kembalian'
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'PenjualanID');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'UserID');
    }
}
