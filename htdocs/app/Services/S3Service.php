<?php
namespace App\Services;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/**
 * [S3]へアクセスするサービスクラス
 */

class S3Service {
    private object $s3Client;
    private string $bucket;

    public function __construct()
    {
        $this->s3Client = new S3Client([
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
        ]);

        $this->bucket = config('filesystems.disks.s3.bucket');
    }

    /**
     * S3へ保存したオブジェクトを取得する
     * 
     * @param string $path 取得するオブジェクトのパス
     * @return string 署名付きURL
     */
    public function fetchObject($path) {
        $cmd = $this->s3Client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => $path
        ]);

        $request = $this->s3Client->createPresignedRequest($cmd, '+1 minutes');
        $path = (string)$request->getUri();

        return $path;
    }

}