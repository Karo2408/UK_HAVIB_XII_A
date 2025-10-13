<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'PelangganID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['NamaPelanggan', 'Alamat', 'NomorTelepon'];


}
