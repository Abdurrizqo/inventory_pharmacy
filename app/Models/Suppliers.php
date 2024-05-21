<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    protected $table = 'suppliers';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'supplier_name',
        'contact',
        'address',
    ];
}
