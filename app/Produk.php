<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'ProdukID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['NamaProduk', 'Harga', 'Stok', 'Foto', 'KategoriID'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'KategoriID');
    }

    
}
