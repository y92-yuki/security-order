<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'manufacturer_name',
        'picture',
        'other',
        'is_display',
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
