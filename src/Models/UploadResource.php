<?php

namespace ymlluo\Ueditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class UploadResource extends Model
{
    protected $guarded = [];

    const FILE_TYPE_APPLICATION = 100;
    const FILE_TYPE_IMAGE = 200;
    const FILE_TYPE_AUDIO = 300;
    const FILE_TYPE_VIDEO = 400;
    const FILE_TYPE_TEXT = 500;
    const FILE_TYPE_OTHER = 600;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($table = config('ueditor.resource.custom_table')) {
            $this->table = $table;
        }
    }


    /**
     * 保存文件信息
     * @param array $fileInfo
     */
    public static function store(array $fileInfo)
    {
        $data = [];
        $data['original'] = $fileInfo['original'] ?? '';
        $data['filename'] = $fileInfo['filename'] ?? '';
        $data['pathname'] = $fileInfo['pathname'] ?? '';
        $data['url'] = $fileInfo['url'] ?? '';
        $data['sha1'] = $fileInfo['sha1'] ?? '';
        $data['mime_type'] = $fileInfo['mime_type'] ?? '';
        $data['extension'] = $fileInfo['extension'] ?? 0;
        $data['file_type'] = self::getTypeByMimeType($data['mime_type']);
        $data['size'] = $fileInfo['size'] ?? '';
        $data['extend'] = $fileInfo['extend'] ?? '[]';
        $data['creator_uid'] = $fileInfo['creator_uid'] ?? 0;
        UploadResource::query()->create($data);
    }

    /**
     * get type by mime type
     *
     * @param $mimeType
     * @return int
     */
    public static function getTypeByMimeType($mimeType)
    {
        $prefix = strtolower(explode('/', $mimeType)[0] ?? "");
        switch ($prefix) {
            case 'application':
                $type = self::FILE_TYPE_APPLICATION;
                break;
            case 'image':
                $type = self::FILE_TYPE_IMAGE;
                break;
            case 'audio':
                $type = self::FILE_TYPE_AUDIO;
                break;
            case 'video':
                $type = self::FILE_TYPE_VIDEO;
                break;
            case 'text':
                $type = self::FILE_TYPE_TEXT;
                break;
            default:
                $type = self::FILE_TYPE_OTHER;
                break;
        }
        return $type;
    }

    /**
     *  get history record by file sha1
     * @param UploadedFile $file
     * @return array
     */
    public static function getHistory(UploadedFile $file)
    {
        $sha1 = sha1_file($file->getRealPath());
        $response = [];
        if ($resource = UploadResource::query()->where('sha1', $sha1)->first()) {
            $response = $resource->toArray();
            $response['state'] = 'SUCCESS';
        }
        return $response;

    }

    /**
     * get images list
     * @param $start
     * @param $size
     * @return array
     */
    public static function getImages($start, $size, $path = '', $allowExtension = [])
    {

        $query = UploadResource::query()->where('file_type', UploadResource::FILE_TYPE_IMAGE)->orderByDesc('id');
        if ($path) {
            $query->where('pathname', 'like', $path . '%');
        }
        if ($allowExtension) {
            $query->whereIn('extension', $allowExtension);
        }
        $total = $query->count();
        $lists = $query->offset($start)->limit($size)->get()->toArray();
        return [
            'state' => empty($lists) ? 'EMPTY' : 'SUCCESS',
            'list' => $lists,
            'start' => $start,
            'total' => $total,
        ];
    }

    /**
     * get all files list
     * @param $start
     * @param $size
     * @return array
     */
    public static function getFiles($start, $size, $path = '', $allowExtension = [])
    {
        $query = UploadResource::query()->orderByDesc('id');
        if ($path) {
            $query->where('pathname', 'like', $path . '%');
        }
        if ($allowExtension) {
            $query->whereIn('extension', $allowExtension);
        }
        $total = $query->count();
        $lists = $query->offset($start)->limit($size)->get()->toArray();
        return [
            'state' => empty($lists) ? 'EMPTY' : 'SUCCESS',
            'list' => $lists,
            'start' => $start,
            'total' => $total,
        ];
    }

    /**
     * delete record by path
     * @param $path
     */
    public static function deleteRecords($path)
    {
        $paths = (array)$path;
        foreach ($paths as $fullName) {
            if (preg_match('/^(.*\/)(.*)/is', $fullName, $matchs)) {
                $pathname = '/'.ltrim($matchs['1'],'/');
                UploadResource::query()->where(['pathname' => $pathname, 'filename' => $matchs[2]])->delete();
            }
        }
    }

    /**
     * update resource url by file full path
     * @param $path
     * @param $url
     * @return bool|int
     */
    public static function updateUrl($path, $url)
    {
        if (preg_match('/^(.*\/)(.*)/is', $path, $matchs)) {
            $pathname = '/'.ltrim($matchs['1'],'/');
            return UploadResource::query()->where(['pathname' =>$pathname, 'filename' => $matchs[2]])->update(['url' => $url]);
        }
        return false;
    }


}
