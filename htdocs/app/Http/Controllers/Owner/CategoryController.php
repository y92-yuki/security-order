<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use Inertia\Inertia;
use App\Http\Requests\CategoryRequest;
use App\Services\S3Service;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * 一覧画面表示
     */
    public function index() {
        $categories = Categorie::select('id', 'category_name', 'picture', 'is_display')->get();

        return Inertia::render('Owner/Category/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * 登録画面表示
     */
    public function create() {
        return Inertia::render('Owner/Category/Create');
    }

    /**
     * 登録実行
     */
    public function store(CategoryRequest $request) {
        try {
            $picture_name = null;
            if(!empty($request->picture)) {
                $path = 'owner/category';
                // 画像が添付されている場合、S3へ保存
                $picture_name = Storage::disk('s3')->put($path, $request->picture);
            }

            DB::beginTransaction();
    
            Categorie::create([
                'category_name' => $request->category_name,
                'picture' => $picture_name,
            ]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }

        return to_route('owner.category.index');
    }

    /**
     * 詳細
     */
    public function show(Categorie $category) {
        $path = $category->picture;
        if(!empty($path)) {
            $s3 = new S3Service();
            $path = $s3->fetchObject($path);
        }

        return Inertia::render('Owner/Category/Show', [
            'category' => $category,
            'picture' => $path,
        ]);
    }

    /**
     * 編集
     */
    public function edit(Categorie $category) {
        return Inertia::render('Owner/Category/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * 編集実行
     */
    public function update(CategoryRequest $request) {
        try {
            DB::beginTransaction();

            $category = Categorie::findOrFail($request->id);
            $category->category_name = $request->category_name;

            // 2 -> 画像変更 or 追加
            if($request->is_picture_modify === '2') {
                // 登録済みの画像は削除
                if(!empty($category->picture)) {
                    Storage::disk('s3')->delete($category->picture);
                }

                // 画像を保存
                $path = 'owner/category';
                $category->picture = Storage::disk('s3')->put($path, $request->picture);
            }
    
            // 3 -> 画像削除
            if($request->is_picture_modify === '3' && !empty($category->picture)) {
                Storage::disk('s3')->delete($category->picture);
                $category->picture = null;
            }

            $category->save();

            DB::commit();

        } catch(\Exception $e) {
            DB::rollBack();
        }


        return to_route('owner.category.index');
    }

    /**
     * 表示・非表示の切り替え
     */
    public function toggleDisplay(Request $request) {
        Categorie::findOrFail($request->id)->update([
            'is_display' => $request->is_display,
        ]);

        return to_route('owner.category.index');
    }

    public function destroy(Request $request) {
        try {
            DB::beginTransaction();

            $category = Categorie::findOrFail($request->id);
            $category->products()->delete();
            $category->delete();

            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
        }

        return to_route('owner.category.index');
    }
}
