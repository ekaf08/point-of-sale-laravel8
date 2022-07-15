<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'id_supplier');
    }
}
