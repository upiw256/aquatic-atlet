<?php

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use App\Models\UserModel;
if (!function_exists('uploadToR2')) {
    function uploadToR2($file, $userId, $folder = 'photos')
    {
        
        $bucket = env('R2_BUCKET');
        $endpoint = env('R2_ENDPOINT');

        $s3 = new S3Client([
            'region' => env('R2_REGION'),
            'version' => 'latest',
            'endpoint' => $endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => env('R2_KEY'),
                'secret' => env('R2_SECRET'),
            ],
        ]);

        // Gunakan nama file fix berdasarkan user_id
        $ext = $file->getClientExtension(); // jpg/png
        $key = "{$folder}/user_{$userId}.{$ext}";

        try {
            $result = $s3->putObject([
                'Bucket'     => $bucket,
                'Key'        => $key,
                'SourceFile' => $file->getRealPath(),
                'ACL'        => 'public-read', // opsional
            ]);

            // URL dari CDN
            return rtrim(env('R2_CDN'), '/') . '/' . $key;
        } catch (AwsException $e) {
            log_message('error', 'Upload ke R2 gagal: ' . $e->getMessage());
            return false;
        }
    }
}
