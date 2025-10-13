<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'PembayaranID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'PenjualanID',
        'Metode',
        'JumlahBayar',
        'Kembalian',
        'Status',
    ];

    // Relasi ke Penjualan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');
    }
}
