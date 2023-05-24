<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $primaryKey = 'id_satuan';

    public function bahan()
    {
        return $this->belongsToMany('App\Bahan', 'satuan', 'id_satuan');
    }

    public function produk()
    {
        return $this->belongsToMany('App\produk', 'satuan', 'id_satuan');
    }
}
