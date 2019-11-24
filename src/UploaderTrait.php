<?php namespace ymlluo\Ueditor;

use Freyo\Flysystem\QcloudCOSv5\Adapter as CosAdapter;
use Illuminate\Http\UploadedFile;
use Jacobcyl\AliOSS\AliOssAdapter;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

trait UploaderTrait
{
//


    /**
     * upload file
     * @param $path
     * @param $filename
     * @param UploadedFile $file
     * @return bool|false|mixed|string|null
     */
    public function uploader($path, $filename, UploadedFile $file)
    {
        try {
            $options = ['disk' => $this->disk, 'visibility' => $this->getDiskConfig('visibility','public')];
            $adapter = $this->driver->getAdapter();
            $fullName = ltrim($path . $filename, '/');
            if ($file->getSize() < $this->spit_size) {
                if (version_compare(app()->version(),'5.4.0','lt')){
                    return $this->storage->putFileAs($path, $file, $filename, $options['visibility']);
                }
                return $this->storage->putFileAs($path, $file, $filename, $options);


            } else {
                if ($adapter instanceof AwsS3Adapter) {
                    return $this->uploadMultiAws($adapter, $fullName, $file);
                } elseif ($adapter instanceof AliOssAdapter) {
                    return $this->uploadMultiOss($adapter, $fullName, $file);
                } elseif ($adapter instanceof CosAdapter) {
                    return $this->uploadMultiCos($adapter, $fullName, $file);
                } else {
                    return $this->storage->putFileAs($path, $file, $filename, $options);
                }
            }
        } catch (\Exception $exception) {
            throw $exception;
            return false;
        }

    }

    /**
     * upload file to AWS S3 use multipart
     * @param AwsS3Adapter $adapter
     * @param $fullName
     * @param $file
     * @return bool|mixed
     */
    protected function uploadMultiAws(AwsS3Adapter $adapter, $fullName, $file)
    {
        $client = $adapter->getClient();
//        'ACL' => 'private|public-read|public-read-write|authenticated-read|aws-exec-read|bucket-owner-read|bucket-owner-full-control',
        $acl = $this->getAcl();
        try {
            return $client->upload($adapter->getBucket(), $fullName, $file, $acl, ['params' => [
                'mup_threshold' => $this->spit_size
            ]]);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * upload file to Aliyun OSS use multipart
     * @param AliOssAdapter $adapter
     * @param $fullName
     * @param UploadedFile $file
     * @return bool|null
     */
    protected function uploadMultiOss(AliOssAdapter $adapter, $fullName, UploadedFile $file)
    {
        try {
            $client = $adapter->getClient();
            $options = ['x-oss-object-acl' => $this->getAcl()];
            $data = $client->multiuploadFile($adapter->getBucket(), $fullName, $file->getRealPath(), $options);
            return $data;
        } catch (\Exception $exception) {
            return false;
        }

    }

    /**
     * upload file to Tencent COS use multipart
     *
     * @param CosAdapter $adapter
     * @param $fullName
     * @param UploadedFile $file
     * @return mixed
     */
    protected function uploadMultiCos(CosAdapter $adapter, $fullName, UploadedFile $file)
    {
        $data = $adapter->getCOSClient()->Upload(
            $adapter->getBucket(),
            $fullName,
            $file, [
                'min_part_size' => $this->spit_size,
                'ACL' => $this->getAcl()
            ]
        );
        return $data;
    }

    protected function getAcl()
    {
        $acl = $this->isSignUrl() ? 'private' : 'public-read';
        return $acl;
    }

}
