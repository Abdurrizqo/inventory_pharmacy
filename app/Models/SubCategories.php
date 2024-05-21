<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    protected $table = 'sub_categories';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'sub_category_name',
        'category_id',
    ];
}
