<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ShoppingController extends Controller
{
  public function index()
  {
    return Inertia::render('User/Index');
  }

  public function categoryIndex()
  {
    return Inertia::render('User/Category');
  }
}
