<?php

use App\Http\Controllers\Owner\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\ManufacturerController;
use App\Http\Controllers\User\ShoppingController;
use App\Http\Controllers\Owner\CategoryController;
use App\Models\Categorie;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 商品一覧画面から検索
 */
Route::get('product/search', [ProductController::class, 'search'])->name('api.product.search');

/**
 * メーカー詳細から関連商品を取得する
 */
Route::get('manufacturer/get-relation-item-list', [ManufacturerController::class, 'getRelationItemList'])
                                                                ->name('api.manufacturer.get_relation_item_list');

/**
 * カテゴリー詳細から関連商品を取得する
 */
Route::get('category/get-relation-item-list', [CategoryController::class, 'getRelationItemList'])
                                                                ->name('api.category.get_relation_item_list');

Route::get('shopping/product/', [ShoppingController::class, 'getDisplayProducts'])->name('api.shopping.product.index');