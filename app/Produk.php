<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $primaryKey = 'id_produk';

    public function bahan()
    {
        return $this->hasOne('App\Bahan', 'id_bahan', 'nm_bahan');
    }

    public function satuanRelasi()
    {
        return $this->hasOne('App\Satuan', 'id_satuan', 'satuan');
    }
}
