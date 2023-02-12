<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Manufacturer;
use App\Models\Categorie;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        $products = Product::select('id', 'product_name', 'picture', 'price', 'is_selling')->get();

        return Inertia::render('Owner/Product/Index', [
            'products' => $products,
        ]);
    }
    
    public function create() {
        $manufacturers = Manufacturer::select('id', 'manufacturer_name')->get();
        $categories = Categorie::select('id', 'category_name')->get();

        return Inertia::render('Owner/Product/Create', [
            'manufacturers' => $manufacturers,
            'categories' => $categories,
        ]);
    }

    public function store(ProductRequest $request) {

        try {
            $picture_name = null;
            if(!empty($request->picture)) {
                $path = 'owner/product';
                $picture_name = Storage::disk('s3')->put($path, $request->picture);
            }

            DB::beginTransaction();
    
            Product::create([
                'product_name'    => $request->product_name,
                'picture'         => $picture_name,
                'category_id'     => $request->category_id,
                'manufacturer_id' => $request->manufacturer_id,
                'price'           => $request->price,
                'memo'            => $request->memo,
            ]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }

        return to_route('owner.product.index');
    }
}
