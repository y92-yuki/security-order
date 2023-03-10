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
use App\Services\S3Service;

class ProductController extends Controller
{
  public function index(Request $request)
  {
    $products = Product::select('id', 'product_name', 'picture', 'price', 'is_selling')->paginate(50);

    // 不正なGETパラメーターの場合は一覧画面のトップへ
    if ($request->page > $products->lastPage()) {
      return to_route('owner.product.index');
    }

    return Inertia::render('Owner/Product/Index', [
      'products' => $products,
    ]);
  }

  public function show($id)
  {
    $product = Product::with('manufacturer', 'category')->findOrFail($id);

    $path = $product->picture;
    if (!empty($path)) {
      $s3 = new S3Service();
      $path = $s3->fetchObject($path);
    }

    return Inertia::render('Owner/Product/Show', [
      'product' => $product,
      'picture' => $path,
    ]);
  }

  public function create()
  {
    $manufacturers = Manufacturer::select('id', 'manufacturer_name')->get();
    $categories = Categorie::select('id', 'category_name')->get();

    return Inertia::render('Owner/Product/Create', [
      'manufacturers' => $manufacturers,
      'categories' => $categories,
    ]);
  }

  public function store(ProductRequest $request)
  {

    try {
      $picture_name = null;
      if (!empty($request->picture)) {
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
    } catch (\Exception $e) {
      DB::rollBack();
    }

    return to_route('owner.product.index');
  }

  public function edit($id)
  {
    $manufacturers = Manufacturer::select('id', 'manufacturer_name')->get();
    $categories = Categorie::select('id', 'category_name')->get();
    $product = Product::with('manufacturer', 'category')->findOrFail($id);

    return Inertia::render('Owner/Product/Edit', [
      'manufacturers' => $manufacturers,
      'categories'    => $categories,
      'product'       => $product,
    ]);
  }

  public function update(ProductRequest $request)
  {
    $product = Product::findOrFail($request->id);
    // 2 -> 画像を変更 or 追加
    if ($request->is_picture_modify === '2') {
      // すでに画像が登録されている場合は登録済みの画像を削除する
      if (!empty($product->picture)) {
        Storage::disk('s3')->delete($product->picture);
      }

      $path = 'owner/product';
      $product->picture = Storage::disk('s3')->put($path, $request->picture);
    }

    // 3 -> 画像を削除
    if ($request->is_picture_modify === '3' && !empty($product->picture)) {
      Storage::disk('s3')->delete($product->picture);
      $product->picture = null;
    }

    $product->product_name    = $request->product_name;
    $product->manufacturer_id = $request->manufacturer_id;
    $product->category_id     = $request->category_id;
    $product->price           = $request->price;
    $product->memo            = $request->memo;

    $product->save();

    return to_route('owner.product.index');
  }

  public function toggleSelling(Request $request)
  {
    $product = Product::findOrFail($request->id);
    $product->is_selling = $request->is_selling;
    $product->save();
    $page = $request->page;

    // メーカー詳細画面からのリクエストの場合
    if ($request->manufacturer_id) {
      return to_route('owner.manufacturer.show', [
        'manufacturer' => $request->manufacturer_id,
      ]);
    }

    // カテゴリー詳細画面からのリクエストの場合
    if ($request->category_id) {
      return to_route('owner.category.show', [
        'category' => $request->category_id,
      ]);
    }

    return to_route('owner.product.index', compact('page'));
  }

  public function destroy(Request $request)
  {
    Product::findOrFail($request->id)->delete();

    return to_route('owner.product.index');
  }

  public function search(Request $request)
  {
    $search = $request->search;

    $products = Product::where('product_name', 'LIKE', '%' . $search . '%')
      ->orWhereHas('manufacturer', function ($query) use ($search) {
        $query->where('manufacturer_name', 'LIKE', '%' . $search . '%');
      })->orWhereHas('category', function ($query) use ($search) {
        $query->where('category_name', 'LIKE', '%' . $search . '%');
      })->get();

    return $products;
  }
}
