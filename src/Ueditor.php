<?php namespace ymlluo\Ueditor;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ymlluo\Ueditor\Events\FileUploaded;
use ymlluo\Ueditor\Models\UploadResource;

class Ueditor
{
    use UrlGenerateTrait, UploaderTrait;

    public $storage;

    public $disk;

    public $driver;

    public $spit_size;

    public function __construct()
    {
        $this->disk = config('ueditor.disk', 'public');
        $this->spit_size = config('ueditor.spit_size');
        $this->storage = Storage::disk($this->disk);
        $this->driver = $this->storage->getDriver();
        if ($this->disk == 'public' && !file_exists(public_path('storage'))&& version_compare(app()->version(),'5.3.0','>=')) {
            Artisan::call('storage:link');
        }
//        dump($this->storage->getDriver());
    }


    /**
     * file upload
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \OSS\Core\OssException
     */
    public function upload(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return $this->fail(trans('ueditor::lang.method_not_allowed'));
        }
        $action = $request->get('action');
        $config = $this->getConfigByActionName($action);
        $field_name = $config['field_name'];
        if ($this->getNameByAction($action) == 'scrawlActionName') {
            $str = base64_decode($request->get($field_name));
            $file = $this->createPng($str);
        } else {
            $file = $request->file($field_name);
            if (!$file->isValid($field_name)) {
                return $this->fail(trans('ueditor::lang.file_invalid'));
            }
            if (!in_array('.' . strtolower($file->getClientOriginalExtension()), $config['allow_files'])) {
                return $this->fail(trans('ueditor::lang.file_type_not_allowed'));
            }
        }
        if ($file->getSize() > $config['max_size']) {
            return $this->fail(trans('ueditor::lang.file_size_exceeded'));
        }
        $fileInfo = $this->getFileInfo($file);
        if ($this->isResourceEnable()) {
            $resource = UploadResource::where('sha1', $fileInfo['sha1'])->first();
            if ($resource) {
                $data = $resource->toArray();
                $data['state'] = 'SUCCESS';
                return response()->json($data);
            }
        }
        $path = $this->formatPath($config['path']);
        $filename = $this->formatFilename($file, $config['filename']);
        $fullName = $path . $filename;
        $result = $this->uploader($path, $filename, $file);
        if (!$result) {
            return $this->fail(trans('ueditor::lang.file_upload_error'));
        }

        $url = $this->url($fullName, $this->getDiskConfig('visibility','public'), $this->getExpire());
        $data = [
            'state' => 'SUCCESS',
            'path' => $fullName,
            'filename' => $filename,
            'url' => $url,
            'creator_uid' => intval(auth()->id())
        ];
        $data = array_merge($fileInfo, $data);
        if (version_compare(app()->version(),'5.3.0','>=')){
            event(new FileUploaded($data));
        }
        return response()->json($data);
    }


    /**
     * show images list
     * @param int $start
     * @param int $size
     * @param string $path
     * @param array $allowExtension
     * @return array|mixed
     */
    public function listImages(int $start, int $size = 20, string $path = '', array $allowExtension = [])
    {
        $path = config('ueditor.upload_configs.imageManagerListPath');
        $allowExtension = array_map(function ($str) {
            return substr($str, 1, strlen($str));
        }, config('ueditor.upload_configs.imageManagerAllowFiles'));
        if ($this->isResourceEnable()) {
            return UploadResource::getImages($start, $size, $path, $allowExtension);
        }
        $all = $this->getFiles($path, $allowExtension);
        return $this->filePaginate($all, $start, $size);
    }


    /**
     * show files list
     * @param int $start
     * @param int $size
     * @param string $path
     * @param array $allowExtension
     * @return array|mixed
     */
    public function listFiles(int $start, int $size = 20, string $path = '', array $allowExtension = [])
    {
        $path = $path ?: config('ueditor.upload_configs.fileManagerListPath');
        $allowExtension = array_map(function ($str) {
            return substr($str, 1, strlen($str));
        }, config('ueditor.upload_configs.fileManagerAllowFiles'));
        if ($this->isResourceEnable()) {
            return UploadResource::getFiles($start, $size, $path, $allowExtension);
        }

        $all = $this->getFiles($path, $allowExtension);
        return $this->filePaginate($all, $start, $size);
    }

    /**
     * get config ActionName
     * @param $action
     * @return mixed
     */
    public function getNameByAction($action)
    {
        $configs = config('ueditor.upload_configs');
        $reverseConfig = array_flip(array_filter($configs, function ($key) {
            return strpos($key, 'ActionName');
        }, ARRAY_FILTER_USE_KEY));
        $actionKey = $reverseConfig[$action];
        return $actionKey;
    }

    /**
     *  set file visibility url
     * @param $path
     * @param $visibility
     * @return bool|int
     */
    public function setVisibilityUrl($path, $visibility)
    {
        $path = trim($path, '/');
        $this->storage->setVisibility($path, $visibility);
        try {
            $url = $this->url($path, $visibility);
        } catch (\Exception $exception) {
            $url = '';
        }
        if ($this->isResourceEnable()) {
            return UploadResource::updateUrl($path, $url);
        }
        return $url;
    }


    /**
     * is resource manager enabled
     * @return \Illuminate\Config\Repository|mixed
     */
    public function isResourceEnable()
    {
        return config('ueditor.resource.enable');
    }

    /**
     * delete file by path
     * @param $path
     * @return bool
     */
    public function deleteResource($path)
    {
        $path = ltrim($path, '/');
        if ($this->storage->exists($path)) {
            return $this->storage->delete($path);
        }
        return true;
    }


    /**
     * get files pagination
     * @param array $files
     * @param int $start
     * @param int $size
     * @return mixed
     */
    protected function filePaginate(array $allFiles, $start = 0, $size = 20)
    {
        array_multisort(array_column($allFiles, 'timestamp'), SORT_DESC, $allFiles);
        $files = array_slice($allFiles, $start, $size);
        $files = array_map(function ($file) {
            $file['url'] = $this->url($file['path']);
            $file['mtime'] = $file['timestamp'];
            return $file;
        }, $files);
        return [
            'state' => empty($files) ? 'EMPTY' : 'SUCCESS',
            'list' => $files,
            'start' => $start,
            'total' => count($allFiles),
        ];
    }

    /**
     * get files from storage
     * @param string $path
     * @param array $allowExtension
     * @return array
     */
    protected function getFiles(string $path, array $allowExtension)
    {
        $files = $this->storage->listContents($path, true);
        $files = array_filter($files, function ($file) use ($allowExtension) {
            if ($file['type'] != 'file') {
                return false;
            }
            return in_array('.' . ($file['extension'] ?? ''), $allowExtension);
        });
        return $files;
    }


    /**
     * fail response
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fail($message)
    {
        return response()->json(['state' => __($message)], 200, [], 256);
    }

    /**
     * Check if the url requires a signature
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function isSignUrl($visibility = '')
    {
        $visibility = $visibility ?: $this->getDiskConfig('visibility','public');
        return $visibility == 'private';
    }

    protected function getDiskConfig($key, $default = null)
    {
        $configs = (array)config('filesystems.disks.' . $this->disk);
        if ($key) {
            return $configs[$key] ?? $default;
        }
        return $configs;
    }

    /**
     * get sign url expire seconds ,if set to 0  that means it's forever (100 yeas)
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function getExpire(int $expiration = 0)
    {

        return $expiration ?: $this->getDiskConfig('expiration', 0);
    }

    /**
     * get config by actionName
     * @param string $action
     * @return array
     */
    protected function getConfigByActionName(string $action): array
    {
        $actionKey = $this->getNameByAction($action);
        $prefix = substr($actionKey, 0, strpos($actionKey, 'ActionName'));
        return $this->formatConfigByPrefix($prefix);
    }

    /**
     * get config by request prefix
     * @param $prefix
     * @return array
     */
    protected function formatConfigByPrefix($prefix)
    {
        $uploadConfig = config('ueditor.upload_configs');
        $config = [
            'field_name' => $uploadConfig[$prefix . 'FieldName'] ?? '',
            'max_size' => $uploadConfig[$prefix . 'MaxSize'] ?? '',
            'allow_files' => $uploadConfig[$prefix . 'AllowFiles'] ?? '',
            'path' => $uploadConfig[$prefix . 'PathFormat'] ?? '',
            'filename' => $uploadConfig[$prefix . 'FileName'] ?? '',
        ];
        return $config;
    }

    /**
     * generate real path
     * @param $path
     * @return string
     */
    protected function formatPath($path)
    {
        $maps = [
            "{yyyy}" => date("Y", time()),
            "{yy}" => date("y", time()),
            "{mm}" => date("m", time()),
            "{dd}" => date("d", time()),
            "{hh}" => date("H", time()),
            "{ii}" => date("i", time()),
            "{ss}" => date("s", time()),
        ];
        $path = str_replace(array_keys($maps), array_values($maps), $path);
        return Str::finish($path, '/');
    }

    /**
     * generate format filename from config
     * @param UploadedFile $file
     * @param $config
     * @return string|null
     */
    protected function formatFilename(UploadedFile $file, $config)
    {
        $originExtension = $file->getClientOriginalExtension();
        $originName = preg_replace('/[%#]/is', '_', explode($originExtension, $file->getClientOriginalName())[0]). $originExtension;
        if (preg_match('/\{rand:(\d+)\}/is', $config, $m)) {
            $len = $m[1] > 256 ? 256 : $m[1];
            $filename = Str::random($len) . '.' . $originExtension;
        } elseif (preg_match('/{filename}/is', $config)) {
            $filename = $originName;
        } else {
            $filename = Str::random(6) . '_' . $originName;
        }
        return strtolower($filename);

    }

    /**
     * create tmp png file from base64 string
     * @param $string
     * @return UploadedFile
     */
    protected function createPng($string)
    {
        $filename = Str::random(16) . '.png';
        $tmpFile = sys_get_temp_dir() . '/' . $filename;
        file_put_contents($tmpFile, $string);
        return new UploadedFile($tmpFile, $filename, 'image/png');
    }


    /**
     * get file info
     * @param UploadedFile $file
     * @return array
     */
    protected function getFileInfo(UploadedFile $file)
    {
        $data = array_fill_keys(['width', 'height'], 0);
        if (strpos($file->getMimeType(), 'image') === 0) {
            $info = (array)getimagesize($file->getRealPath());
            $data['width'] = intval($info[0] ?? 0);
            $data['height'] = intval($info[1] ?? 0);
        }
        $data['size'] = $file->getSize();
        $data['original'] = $file->getClientOriginalName();
        $data['title'] = $file->getClientOriginalName();
        $data['extension'] = $file->getClientOriginalExtension();
        $data['mime_type'] = $file->getMimeType();
        $data['sha1'] = sha1_file($file->getRealPath());
        return $data;

    }


}
