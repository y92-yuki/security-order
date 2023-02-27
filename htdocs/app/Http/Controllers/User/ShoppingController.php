<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ShoppingController extends Controller
{
    public function index() {

        return Inertia::render('User/Index');
    }

    public function getDisplayProducts(Request $request) {
        $limit = 50;
        $offset = ($request->page - 1) * $limit;
        $products = Product::with('manufacturer', 'category')
                                ->offset($offset)->limit($limit)->get();

        return $products;
    }
}
