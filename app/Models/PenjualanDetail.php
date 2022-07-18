<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'id_produk');
    }
}
