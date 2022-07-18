<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_pembelian';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'id_produk');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'id_member');
    }
}
