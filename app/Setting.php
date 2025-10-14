<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings'; // nama tabel
    protected $primaryKey = 'id';
    protected $fillable = ['key_name', 'value'];
    public $timestamps = false;

    // Ambil nilai berdasarkan key
    public static function getValue($key)
    {
        return self::where('key_name', $key)->value('value');
    }

    // Simpan atau update
    public static function setValue($key, $value)
    {
        return self::updateOrCreate(
            ['key_name' => $key],
            ['value' => $value]
        );
    }
}