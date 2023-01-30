<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Manufacturer;
use App\Http\Requests\ManufacturerRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManufacturerController extends Controller
{
    public function index() {
        $manufacturers = Manufacturer::select('id', 'manufacturer_name', 'picture', 'other')->get();
        
        return Inertia::render('Owner/Manufacturer/Index',[
            'manufacturers' => $manufacturers,
        ]);
    }

    public function create() {
        return Inertia::render('Owner/Manufacturer/Create');
    }

    public function store(ManufacturerRequest $request) {
        // 画像が添付されている場合、現在のタイムスタンプ + ランダム文字列 + 拡張子でDBにファイル名を保存する。
        $picture_name = null;
        if (!empty($request->picture)) {
            $prefix = 'images/manufacturer/';
            $extension = $request->picture->extension();
            $picture_name = time() . Str::random(16) . '.' . $extension;
        }

        try {
            DB::beginTransaction();

            Manufacturer::create([
                'manufacturer_name' => $request->manufacturer_name,
                'picture' => $picture_name,
                'other' => $request->other,
            ]);

            if ($picture_name) {
                Storage::disk('s3')->put($prefix . $picture_name, $request->picture);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }


        return to_route('owner.manufacturer.index');
    }

    public function show(Manufacturer $manufacturer) {
        dd($manufacturer);
    }
}
