<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $primaryKey = 'id_bahan';

    public function produk()
    {
        return $this->belongsTo('App\Produk', 'id_bahan', 'nm_bahan');
    }

    public function satuanRelasi()
    {
        return $this->hasOne('App\Satuan', 'id_satuan', 'satuan');
    }
}
