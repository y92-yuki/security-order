<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Manufacturer;
use App\Http\Requests\ManufacturerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;



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
        try {

            $picture_name = null;
            if (!empty($request->picture)) {
                $path = 'manufacturer';
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

    public function show(Manufacturer $manufacturer) {
        dd(Storage::disk('s3')->config);
        $s3Client = new S3Client([
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
        ]);
        
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key' => 'manufacturer/PjOSmKbO2b3oYA5NgrVTaMZrWQR33U1MhM19ccyb.jpg'
        ]);
        
        $request = $s3Client->createPresignedRequest($cmd, '+1 minutes');
        
        $path = (string)$request->getUri();
        dd($path);
        return Inertia::render('Owner/Manufacturer/Show',[
            'manufacturer' => $manufacturer,
            'picturer'
        ]);
    }
}
