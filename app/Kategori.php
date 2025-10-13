<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'KategoriID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['NamaKategori'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'KategoriID');
    }
}
