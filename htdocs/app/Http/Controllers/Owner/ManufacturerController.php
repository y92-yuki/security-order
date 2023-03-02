<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Http\Requests\ManufacturerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\S3Service;
use Exception;

class ManufacturerController extends Controller
{
  /**
   * メーカーの一覧画面表示
   */
  public function index()
  {
    $manufacturers = Manufacturer::select('id', 'manufacturer_name', 'picture', 'other', 'is_display')->get();
    return Inertia::render('Owner/Manufacturer/Index', [
      'manufacturers' => $manufacturers,
    ]);
  }

  /**
   * メーカーの登録画面を表示
   */
  public function create()
  {
    return Inertia::render('Owner/Manufacturer/Create');
  }

  /**
   * メーカーを登録
   */
  public function store(ManufacturerRequest $request)
  {
    try {
      $picture_name = null;
      if (!empty($request->picture)) {
        $path = 'owner/manufacturer';
        // 画像が添付されている場合、S3へ保存
        $picture_name = Storage::disk('s3')->put($path, $request->picture);
      }

      DB::beginTransaction();

      Manufacturer::create([
        'manufacturer_name' => $request->manufacturer_name,
        'picture' => $picture_name,
        'other' => $request->other,
      ]);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
    }

    return to_route('owner.manufacturer.index');
  }

  /**
   * メーカー詳細
   */
  public function show(Manufacturer $manufacturer)
  {
    $path = $manufacturer->picture;
    if (!empty($path)) {
      $s3 = new S3Service();
      $path = $s3->fetchObject($path);
    }

    return Inertia::render('Owner/Manufacturer/Show', [
      'manufacturer' => $manufacturer,
      'picture' => $path,
    ]);
  }

  /**
   * メーカー編集画面
   */
  public function edit(Manufacturer $manufacturer)
  {
    return Inertia::render('Owner/Manufacturer/Edit', [
      'manufacturer' => $manufacturer,
    ]);
  }

  /**
   * メーカー編集実行
   */
  public function update(ManufacturerRequest $request)
  {
    $manufacturer = Manufacturer::findOrFail($request->id);
    $manufacturer->manufacturer_name = $request->manufacturer_name;
    $manufacturer->other = $request->other;

    // 2 -> 画像を変更 or 追加
    if ($request->is_picture_modify === '2') {
      // すでに画像が登録されている場合は登録済みの画像を削除する
      if (!empty($manufacturer->picture)) {
        Storage::disk('s3')->delete($manufacturer->picture);
      }

      $path = 'owner/manufacturer';
      $manufacturer->picture = Storage::disk('s3')->put($path, $request->picture);
    }

    // 3 -> 画像を削除する
    if ($request->is_picture_modify === '3' && !empty($manufacturer->picture)) {
      Storage::disk('s3')->delete($manufacturer->picture);
      $manufacturer->picture = null;
    }

    $manufacturer->save();

    return to_route('owner.manufacturer.index');
  }

  /**
   * 表示・非表示の切り替え
   */
  public function toggleDisplay(Request $request)
  {
    Manufacturer::findOrFail($request->id)->update([
      'is_display' => $request->is_display,
    ]);

    return to_route('owner.manufacturer.index');
  }

  public function destroy(Request $request)
  {
    try {
      DB::beginTransaction();

      $manufacturer = Manufacturer::findOrFail($request->id);
      $manufacturer->products()->delete();
      $manufacturer->delete();

      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
    }

    return to_route('owner.manufacturer.index');
  }

  /**
   * 関連商品を表示
   */
  public function getRelationItemList(Request $request)
  {
    $products = Product::where('manufacturer_id', '=', $request->id)->get();
    return $products;
  }
}
