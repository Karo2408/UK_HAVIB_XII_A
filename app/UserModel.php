<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';              // tabel custom
    protected $primaryKey = 'UserID';       // PK custom
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nama', 'Email', 'Password', 'Role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'UserID');
    }
    
}
