<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'stok';

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'harga_satuan',
        'obat_id',
        'supplier_id',
        'jumlah_stok',
        'exp_date',
    ];
}
