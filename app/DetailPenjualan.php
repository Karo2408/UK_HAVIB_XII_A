<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'DetailID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'PenjualanID',
        'ProdukID',
        'JumlahProduk',
        'Harga',
        'Subtotal',
        'Diskon'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID');
    }
}
