<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = [
    'product_name',
    'picture',
    'category_id',
    'manufacturer_id',
    'price',
    'is_selling',
    'memo',
  ];

  public function manufacturer()
  {
    return $this->belongsTo(Manufacturer::class);
  }

  public function category()
  {
    return $this->belongsTo(Categorie::class);
  }
}
