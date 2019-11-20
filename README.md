# laravel-UEditor

此 Laravel 5 Package 是 Ueditor 的后端服务。

* 支持 Laravel >= 5.5 版本
* 基于 laravel的storage 实现文件的管理上传等
* 支持 本地、阿里云 OSS、腾讯COS、七牛，AWS S3,京东云 OSS 等（理论支持全部 Flysystem Adapter）
* 后端支持大文件分片上传
* 提供上传文件管理，重复文件上传时直接返回结果
* 提供上传完成后的 Event 支持
* 配置 Visibility 为 private 时 生成带签名的链接
* 支持配置跨域上传
* 支持多语言

## 安装

Via Composer

```bash
$ composer require ymlluo/laravel-ueditor
```
## 配置

1. 添加下面一行到 config/app.php 中 providers 部分：
> Laravel > 5.5 支持 Package Auto-Discovery 无需手动添加配置
  ```
   ymlluo\Ueditor\UeditorServiceProvider::class
```
2.如果使用文件管理功能建议在 config/app.php 中的 aliases 部分添加 （API 参考 api_doc）
```$xslt
  "Ueditor" => ymlluo\Ueditor\Facades\Ueditor::class
```
3.发布配置文件
```$xslt
php artisan vendor:publish --provider="ymlluo\\Ueditor\\UeditorServiceProvider"
```
4.如果使用资源管理功能，需要运行 `php artisan migrate` 生成数据库中的表， 修改 config/ueditor.php 配置如下：
```php
    'resource' => [
        'enable' => true,//设置为 true 标示使用资源表存储记录。首次安装会需要运行 php artisan migrate
        'file_unique'=>true,//根据文件的sha1 判断，如果已经存在直接返回已经存在的文件信息，防止重复上传
        'custom_table' => '', //默认上传的表名为 upload_resources,可以自定义表名,
    ],
```

## 使用说明
> 此 package 只包含服务端内容，前端编辑器内容请自行下载

> **disk 配置中的 visibility 设置为 private 时，生成带签名的文件链接,有效期取决于 expiration 的设置，单位是秒（ 0 表示永久）**
### 默认配置说明

```php
    'disk' => 'oss',
    'spit_size' => 10 * 1024 * 1024, //超过10M 的文件上传到 OSS、COS、AWS S3、七牛 等时，使用分片上传
    'route' => [
        'url' => '/serv/ueditor/v1/server', //服务端地址，需要修改前端 ueditor.config.js 中的 serverUrl
        'options' => [
//            'middleware' => ['web','auth'] //正式环境建议取消注释，使用 auth middleware
        ],
        'cors' =>"*" // 默认支持所有跨域请求，支持指定origin 例如 ['http://www.baidu.com'],false 为关闭跨域请求
    ],
    'resource' => [
        'enable' => true,//设置为 true 标示使用资源表存储记录。首次安装会需要运行 php artisan migrate
        'file_unique'=>true,//根据文件的sha1 判断，如果已经存在直接返回已经存在的文件信息，防止重复上传
        'custom_table' => '', //默认上传的表名为 upload_resources,可以自定义表名,
        'route' =>[
        'index'=>    '/serv/resource/index', //资源列表
        'edit'=>    '/serv/resource/edit',  // todo 编辑功能
        'store'=>    '/serv/resource/store', //todo 编辑后保存
        'destroy'=>    '/serv/resource/destroy/{id}' //删除资源
        ]
        ],
```
更多配置请修改 `config/ueditor.php`

### 前端配置注意事项


默认服务器路由地址为：`/serv/ueditor/v1/server` ,你可以修改配置中的 route.url ，改为你自定义的地址，同时需要修改ueditor.config.js 中的 
```html
serverUrl: "/serv/ueditor/v1/server"
```

laravel 默认开启 csrf_token 验证，因此前端需要配置 csrf_token 如下

```html
<!-- 加载编辑器的容器 -->
<script id="container" name="content" type="text/plain">
    这里写你的初始化内容
</script>

<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
        ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.    
    });
</script>
```
或者 把请求路由加入到排除 csrf 列表
```php
# app/Http/Middleware/VerifyCsrfToken.php
    protected $except = [
       '/serv/ueditor/v1/server'
    ];
```


### 本地 Local 支持 
> 默认使用 config/filesystems 中的 public 配置
1. laravel 5.4+ 可以运行 php artisan storage:link ，此操作会创建 storage 目录到 public 目录的软链接。当然你也可以使用下面的方法手动指定目录。
2. laravel 5.3 以下版本，请先创建软链接：
```$xslt
# 请在项目根目录执行以下命令
$ ln -s `pwd`/storage/app/public `pwd`/public/storage
```
### 阿里云 OSS 支持
1. 推荐安装 jacobcyl/ali-oss-storage 
```$xslt
composer require jacobcyl/ali-oss-storage:^2.1
```
> 注意:此 package 使用isCName 存在 Bug，会导致上传失败，但是也没有找到更好的替代库 ，如需使用自定义域名或者 CDN 域名请配置  'url' => env('ALI_OSS_URL', '') 
2. 在config/filesystems 文件中添加 disks 配置
```php
        'oss' => [
            'driver' => 'oss',
            'access_id' => env('ALI_ACCESS_KEY_ID', ''),
            'access_key' => env('ALI_ACCESS_KEY_SECRET', ''),
            'bucket' => env('ALI_OSS_BUCKET', ''),
            'endpoint' => env('ALI_OSS_ENDPOINT', 'oss-cn-beijing.aliyuncs.com'),
            'url' => env('ALI_OSS_URL', ''),
            'ssl' => env('ALI_OSS_SSL', false),
            'isCName' => env('ALI_OSS_IS_CNAME', false),
            'debug' => false,
            'visibility' => 'private',
            'expiration' =>0
        ],
```

### 腾讯云 COSv5 支持

1. 推荐安装 freyo/flysystem-qcloud-cos-v5
```$xslt
composer require freyo/flysystem-qcloud-cos-v5
```
2. 在config/filesystems 文件中添加 disks 配置
```php
        'cosv5' => [
            'driver' => 'cosv5',
            'region' => env('COSV5_REGION', 'ap-guangzhou'),
            'credentials' => [
                'appId' => env('COSV5_APP_ID'),
                'secretId' => env('COSV5_SECRET_ID'),
                'secretKey' => env('COSV5_SECRET_KEY'),
            ],
            'timeout' => env('COSV5_TIMEOUT', 60),
            'connect_timeout' => env('COSV5_CONNECT_TIMEOUT', 60),
            'bucket' => env('COSV5_BUCKET'),
            'cdn' => env('COSV5_CDN'),
            'scheme' => env('COSV5_SCHEME', 'https'),
            'read_from_cdn' => env('COSV5_READ_FROM_CDN', false),
            'cdn_key' => env('COSV5_CDN_KEY'),
            'encrypt' => env('COSV5_ENCRYPT', false),
            'visibility' => 'public',
            'expiration' =>0
        ],
```
### 七牛支持

1. 推荐安装 overtrue/laravel-filesystem-qiniu
```$xslt
composer require overtrue/laravel-filesystem-qiniu
```
2. 在config/filesystems 文件中添加 disks 配置
```php
        'qiniu' => [
            'driver'     => 'qiniu',
            'access_key' => env('QINIU_ACCESS_KEY', 'xxxxxxxxxxxxxxxx'),
            'secret_key' => env('QINIU_SECRET_KEY', 'xxxxxxxxxxxxxxxx'),
            'bucket'     => env('QINIU_BUCKET', 'test'),
            'domain'     => env('QINIU_DOMAIN', 'xxx.clouddn.com'), // or host: https://xxxx.clouddn.com
            'visibility' => 'public',
            'expiration' =>0
        ],
```

### AWS S3 支持


1. 推荐安装 league/flysystem-aws-s3-v3
```$xslt
composer require league/flysystem-aws-s3-v3
```
2. 在config/filesystems 文件中添加 disks 配置

 > 特别注意! AWS S3 v4 版本的 SDK 设置签名链接 最多支持 一周的时间
 
```php
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'visibility' => 'public',
            'expiration' => 7 * 24 * 60  //The expiration date of a signature version 4 presigned URL must be less than one week
        ],
```
### 京东云 OSS

1.京东云 OSS 使用兼容 AWS S3 的 SDK ,推荐安装 league/flysystem-aws-s3-v3

```$xslt
 composer require league/flysystem-aws-s3-v3
 ```
 2. 在config/filesystems 文件中添加 disks 配置
 
 > 特别注意! AWS S3 v4 版本的 SDK 设置签名链接 最多支持 一周的时间
 
```php
        'jd' => [
            'driver' => 's3',
            'key' => env('JD_ACCESS_KEY_ID'),
            'secret' => env('JD_SECRET_ACCESS_KEY'),
            'region' => env('JD_DEFAULT_REGION', 's3.cn-north-1'),
            'endpoint' => env('JD_ENDPOINT', 's3.cn-north-1.jdcloud-oss.com'),
            'bucket' => env('JD_BUCKET'),
            'url' => env('JD_URL'),
            'visibility' => 'private',
            'expiration' => 7 * 24 * 60  //The expiration date of a signature version 4 presigned URL must be less than one week
        ],

```

### 事件
* 上传完成事件
`ymlluo\Ueditor\Events\FileUploaded`

返回  $event->fileInfo;
```json
{
    "fileInfo": {
        "state": "SUCCESS",
        "path": "\/uploads\/image\/2019\/1103\/S6zNUSSGmY4eHDsL.png",
        "filename": "S6zNUSSGmY4eHDsL.png",
        "url": "http:\/\/xxxx.oss-cn-beijing.aliyuncs.com\/uploads\/image\/2019\/1103\/S6zNUSSGmY4eHDsL.png?OSSAccessKeyId=LTAIfnpSloLRDHDj&Expires=1704164395&Signature=lCMSTW4BkzzjMmD4lbl3LI0rtF8%3D",
        "title": "S6zNUSSGmY4eHDsL.png",
        "original": "S6zNUSSGmY4eHDsL.png",
        "type": ".png",
        "extension": ".png",
        "mime_type": "image\/png",
        "size": 13270,
        "sha1": "6c0dc91bb59b1337d97f53fb2608dde9817fbfbe",
        "creator_uid": 0
    },
    "result": null,
    "socket": null
}  


```

## TODO
- [ ] Laravel 小于 5.5 版本支持
- [ ] OSS 服务端签名后直传

## License

license. Please see the [license file](license.md) for more information.

 MIT
