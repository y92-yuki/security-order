<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ShoppingController extends Controller
{
    public function index() {

        $products = Product::with('manufacturer', 'category')->get();
        return Inertia::render('User/Index', compact('products'));
    }
}
