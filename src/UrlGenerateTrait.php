<?php namespace ymlluo\Ueditor;

use Carbon\Carbon;
use Freyo\Flysystem\QcloudCOSv5\Adapter as CosAdapter;
use Illuminate\Support\Str;
use Jacobcyl\AliOSS\AliOssAdapter;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Overtrue\Flysystem\Qiniu\QiniuAdapter;
use RuntimeException;

trait UrlGenerateTrait
{


    public function url(string $path, string $visibility = '', int $expiration = 0, array $options = [])
    {
        if ($this->isSignUrl($visibility)) {
            return $this->temporaryUrl($path, $expiration, $options);
        }
        return $this->publicUrl($path);
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param string $path
     * @return string
     *
     * @throws \RuntimeException
     */
    public function publicUrl($path)
    {
        $adapter = $this->driver->getAdapter();
        if ($adapter instanceof CachedAdapter) {
            $adapter = $adapter->getAdapter();
        }

        if (method_exists($adapter, 'getUrl')) {
            return $adapter->getUrl($path);
        } elseif (method_exists($this->driver, 'getUrl')) {
            return $this->driver->getUrl($path);
        } elseif ($adapter instanceof AwsS3Adapter) {
            return $this->getAwsUrl($adapter, $path);
        } elseif ($adapter instanceof LocalAdapter) {
            return $this->getLocalUrl($path);
        } else {
            throw new RuntimeException('This driver does not support retrieving URLs.');
        }
    }


    /**
     * Get a temporary URL for the file at the given path.
     * @param $path
     * @param $expiration
     * @param array $options
     * @return string|string[]|null
     * @throws \OSS\Core\OssException
     */
    public function temporaryUrl($path, $expiration, array $options = [])
    {
        $adapter = $this->driver->getAdapter();

        if ($adapter instanceof CachedAdapter) {
            $adapter = $adapter->getAdapter();
        }

        if ($adapter instanceof AwsS3Adapter) {
            return $this->getAwsTemporaryUrl($adapter, $path, $expiration, $options);
        } elseif ($adapter instanceof AliOssAdapter) {
            return $this->getOssTemporaryUrl($adapter, $path, $expiration);
        } elseif ($adapter instanceof CosAdapter) {
            return $this->getCosTemporaryUrl($adapter, $path, $expiration, $options);
        } elseif ($adapter instanceof QiniuAdapter) {
            return $this->getQiNiuTemporaryUrl($adapter, $path, $expiration);
        } elseif (method_exists($adapter, 'getTemporaryUrl')) {
            return $adapter->getTemporaryUrl($path, $expiration, $options);
        } else {
            throw new RuntimeException('This driver does not support creating temporary URLs.');
        }
    }


    /**
     *  Get a temporary URL for the file at the given path.
     * @param $adapter
     * @param $path
     * @param $expiration
     * @param $options
     * @return string
     */
    protected function getAwsTemporaryUrl(AwsS3Adapter $adapter, $path, $expiration, $options)
    {
        $client = $adapter->getClient();
        $timeout = $this->expireSeconds($expiration);
        $command = $client->getCommand('GetObject', array_merge([
            'Bucket' => $adapter->getBucket(),
            'Key' => $adapter->getPathPrefix() . $path,
        ], $options));

        return (string)$client->createPresignedRequest(
            $command, Carbon::now()->addSeconds($timeout)
        )->getUri();
    }

    /**
     * Get a Aliyun OSS temporary URL for the file at the given path.
     *
     * @param AliOssAdapter $adapter
     * @param $path
     * @param $timeout
     * @return string|string[]|null
     * @throws \OSS\Core\OssException
     */
    protected function getOssTemporaryUrl(AliOssAdapter $adapter, $path, $expiration)
    {
        $client = $adapter->getClient();
        $timeout = $this->expireSeconds($expiration);
        $url = $client->signUrl(
            $adapter->getBucket(),
            ltrim($path, '/'),
            $timeout
        );
        if (!is_null($origin = $this->driver->getConfig()->get('url'))) {
            return $this->replaceOrigin($url, $origin);
        }
        return $url;
    }

    /**
     * Get a Tencent Cloud COS temporary URL for the file at the given path.
     * @param CosAdapter $adapter
     * @param $path
     * @param $expiration
     * @param array $options
     * @return string|string[]|null
     */
    protected function getCosTemporaryUrl(CosAdapter $adapter, $path, $expiration, $options = [])
    {

        $timeout = $this->expireSeconds($expiration);
        $url = $adapter->getTemporaryUrl(
            ltrim($path, '/'),
            Carbon::now()->addSeconds($timeout)
        );
        if (!is_null($origin = $this->driver->getConfig()->get('url'))) {
            return $this->replaceOrigin($url, $origin);
        }
        return $url;
    }

    /**
     * Get a QiNiu KODO temporary URL for the file at the given path.
     *
     * @param QiniuAdapter $adapter
     * @param $path
     * @param $expiration
     * @param array $options
     * @return string|string[]|null
     */
    protected function getQiNiuTemporaryUrl(QiniuAdapter $adapter, $path, $expiration)
    {

        $timeout = $this->expireSeconds($expiration);
        $url = $adapter->privateDownloadUrl($path, $timeout);
        if (!is_null($origin = $this->driver->getConfig()->get('url'))) {
            return $this->replaceOrigin($url, $origin);
        }
        return $url;
    }


    /**
     * Get the URL for the file at the given path.
     *
     * @param string $path
     * @return string
     */
    protected function getLocalUrl($path)
    {
        $config = $this->driver->getConfig();

        // If an explicit base URL has been set on the disk configuration then we will use
        // it as the base URL instead of the default path. This allows the developer to
        // have full control over the base path for this filesystem's generated URLs.
        if ($config->has('url')) {
            return $this->concatPathToUrl($config->get('url'), $path);
        }

        $path = '/storage/' . $path;

        // If the path contains "storage/public", it probably means the developer is using
        // the default disk to generate the path instead of the "public" disk like they
        // are really supposed to use. We will remove the public from this path here.
        if (Str::contains($path, '/storage/public/')) {
            return Str::replaceFirst('/public/', '/', $path);
        }

        return $path;
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param \League\Flysystem\AwsS3v3\AwsS3Adapter $adapter
     * @param string $path
     * @return string
     */
    protected function getAwsUrl($adapter, $path)
    {
        // If an explicit base URL has been set on the disk configuration then we will use
        // it as the base URL instead of the default path. This allows the developer to
        // have full control over the base path for this filesystem's generated URLs.
        if (!is_null($url = $this->driver->getConfig()->get('url'))) {
            return $this->concatPathToUrl($url, $adapter->getPathPrefix() . $path);
        }

        return $adapter->getClient()->getObjectUrl(
            $adapter->getBucket(), $adapter->getPathPrefix() . $path
        );
    }

    /**
     * Concatenate a path to a URL.
     *
     * @param string $url
     * @param string $path
     * @return string
     */
    protected function concatPathToUrl($url, $path)
    {
        return rtrim($url, '/') . '/' . ltrim($path, '/');
    }

    /**
     * replace url by origin
     * @param $url
     * @param $origin
     * @return string|string[]|null
     */
    protected function replaceOrigin($url, $origin)
    {
        return preg_replace('/https?:\/\/.*?\//is', rtrim($origin) . '/', ltrim($url, '/'));
    }

    /**
     * get expire second
     * @param int $expiration
     * @return float|int
     */
    protected function expireSeconds(int $expiration)
    {
        return $expiration ?: 100 * 365 * 60 * 60;
    }


}