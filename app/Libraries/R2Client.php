<?php

namespace App\Libraries;

use Aws\S3\S3Client;

class R2Client
{
    protected $s3;
    protected $bucket;

    public function __construct()
    {
        $this->bucket = getenv('R2_BUCKET');

        $this->s3 = new S3Client([
            'version'     => 'latest',
            'region'      => getenv('R2_REGION'),
            'endpoint'    => getenv('R2_ENDPOINT'),
            'credentials' => [
                'key'    => getenv('R2_KEY'),
                'secret' => getenv('R2_SECRET'),
            ],
        ]);
    }

    public function upload($key, $filePath, $contentType = 'application/octet-stream')
    {
        return $this->s3->putObject([
            'Bucket'      => $this->bucket,
            'Key'         => $key,
            'SourceFile'  => $filePath,
            'ContentType' => $contentType,
            'ACL'         => 'public-read', // supaya bisa diakses langsung
        ]);
    }

    public function getUrl($key)
    {
        return rtrim(getenv('R2_ENDPOINT'), '/') . '/' . $this->bucket . '/' . ltrim($key, '/');
    }
}
