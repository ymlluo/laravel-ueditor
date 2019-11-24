<?php

namespace ymlluo\Ueditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class UploadResource extends Model
{
    const FILE_TYPE_APPLICATION = 100;
    const FILE_TYPE_IMAGE = 200;
    const FILE_TYPE_AUDIO = 300;
    const FILE_TYPE_VIDEO = 400;
    const FILE_TYPE_TEXT = 500;
    const FILE_TYPE_OTHER = 600;

    protected $guarded = [];
    protected $appends = ['file_type_name', 'file_size'];
    public $table_fields = ['id', 'title', 'filename', 'original', 'path', 'url', 'sha1', 'extension', 'mime_type', 'file_type', 'width', 'height', 'size', 'extend', 'creator_uid', 'created_at', 'updated_at'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($table = config('ueditor.resource.custom_table')) {
            $this->table = $table;
        }
    }

    /**
     * get resource table field
     * @return mixed
     */
    public static function getFields()
    {
        return (new self())->table_fields;
    }


    /**
     * save file info
     * @param array $fileInfo
     */
    public static function store(array $fileInfo)
    {

        $fields = self::getFields();
        foreach ($fileInfo as $key => $item) {
            if (in_array($key, $fields)) {
                $data[$key] = is_array($item) ? json_encode($item, 256) : $item;
            }
        }

        if ($data) {
            $data['file_type'] = self::getTypeByMimeType($data['mime_type']);
            return UploadResource::create($data);
        }
        return false;
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
        if ($resource = UploadResource::where('sha1', $sha1)->first()) {
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

        $query = UploadResource::where('file_type', UploadResource::FILE_TYPE_IMAGE)->orderBy('id','desc');
        if ($path) {
            $query->where('path', 'like', $path . '%');
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
        $query = UploadResource::orderBy('id','desc');
        if ($path) {
            $query->where('path', 'like', $path . '%');
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
        foreach ($paths as $path) {
            UploadResource::where(['path' => $path])->delete();
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
        if ($path) {
            return UploadResource::where(['path' => $path])->update(['url' => $url]);
        }
        return false;

    }

    public function getFileTypeNameAttribute()
    {
        return $this->getFileTypeLabel($this->getAttribute('file_type'));

    }

    public function getFileTypeLabel($file_type)
    {
        $labels = $this->fileTypeMaps();
        return $labels[$file_type]['name'] ?? trans('ueditor::lang.unknown_type');
    }

    public function fileTypeMaps()
    {
        $labels = [
            self::FILE_TYPE_APPLICATION => [
                'name' => trans('ueditor::lang.application')
            ],
            self::FILE_TYPE_IMAGE => [
                'name' => trans('ueditor::lang.image')
            ],
            self::FILE_TYPE_AUDIO => [
                'name' => trans('ueditor::lang.audio')
            ],
            self::FILE_TYPE_VIDEO => [
                'name' => trans('ueditor::lang.video')
            ],
            self::FILE_TYPE_TEXT => [
                'name' => trans('ueditor::lang.text')
            ],
            self::FILE_TYPE_OTHER => [
                'name' => trans('ueditor::lang.other')
            ]
        ];
        return $labels;
    }


    /**
     * get human file size
     * @return string
     */
    public function getFileSizeAttribute()
    {
        return $this->formatBytes($this->getAttribute('size'));
    }

    /**
     * get human file size
     * @param $size
     * @param int $precision
     * @return string
     */
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }


}
