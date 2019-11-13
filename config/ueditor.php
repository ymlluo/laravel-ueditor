<?php

return [
    'disk' => 'public',
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
        'manager_url' =>'/serv/resource/manager/index'
    ],
    'upload_configs' => [
        /* 前后端通信相关的配置,注释只允许使用多行方式 */
        /* 上传图片配置项 */
        'imageActionName' => 'upload_image', /* 执行上传图片的action名称 */
        'imageFieldName' => 'upfile', /* 提交的图片表单名称 */
        'imageMaxSize' => 20 * 1024 * 1024, /* 上传大小限制，单位B */
        'imageAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'], /* 上传图片格式显示 */
        'imageCompressEnable' => true, /* 是否压缩图片,默认是true */
        'imageCompressBorder' => 1600, /* 图片压缩最长边限制 */
        'imageInsertAlign' => 'none', /* 插入的图片浮动方式 */
        'imageUrlPrefix' => '', /* 图片访问路径前缀 */
        'imagePathFormat' => '/uploads/image/{yyyy}/{mm}{dd}/', /* 上传保存路径,可以自定义保存路径和文件名格式 */
        'imageFileName' => '{filename}',
        /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
        /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
        /* {time} 会替换成时间戳 */
        /* {yyyy} 会替换成四位年份 */
        /* {yy} 会替换成两位年份 */
        /* {mm} 会替换成两位月份 */
        /* {dd} 会替换成两位日期 */
        /* {hh} 会替换成两位小时 */
        /* {ii} 会替换成两位分钟 */
        /* {ss} 会替换成两位秒 */
        /* 非法字符 \  => * ? " < > | */
        /* 具请体看线上文档 => fex.baidu.com/assets/#use-format_upload_filename */

        /* 涂鸦图片上传配置项 */
        'scrawlActionName' => 'upload_scrawl', /* 执行上传涂鸦的action名称 */
        'scrawlFieldName' => 'upfile', /* 提交的图片表单名称 */
        'scrawlPathFormat' => '/uploads/image/{yyyy}/{mm}{dd}/', /* 上传保存路径,可以自定义保存路径和文件名格式 */
        'scrawlFileName' => '{filename}',
        'scrawlMaxSize' => 2048000, /* 上传大小限制，单位B */
        'scrawlUrlPrefix' => '', /* 图片访问路径前缀 */
        'scrawlInsertAlign' => 'none',

        /* 截图工具上传 */
        'snapscreenActionName' => 'upload_snapscreen', /* 执行上传截图的action名称 */
        'snapscreenPathFormat' => '/uploads/image/{yyyy}/{mm}{dd}/', /* 上传保存路径,可以自定义保存路径和文件名格式 */
        'snapscreenFileName' => '{filename}',
        'snapscreenUrlPrefix' => '', /* 图片访问路径前缀 */
        'snapscreenInsertAlign' => 'none', /* 插入的图片浮动方式 */

        /* 抓取远程图片配置 */
        'catcherLocalDomain' => ['127.0.0.1', 'localhost', 'img.baidu.com'],
        'catcherActionName' => 'catch_image', /* 执行抓取远程图片的action名称 */
        'catcherFieldName' => 'source', /* 提交的图片列表表单名称 */
        'catcherPathFormat' => '/uploads/image/{yyyy}/{mm}{dd}/', /* 上传保存路径,可以自定义保存路径和文件名格式 */
        'catcherFileName' => '{filename}',
        'catcherUrlPrefix' => '', /* 图片访问路径前缀 */
        'catcherMaxSize' => 2048000, /* 上传大小限制，单位B */
        'catcherAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'], /* 抓取图片格式显示 */

        /* 上传视频配置 */
        'videoActionName' => 'upload_video', /* 执行上传视频的action名称 */
        'videoFieldName' => 'upfile', /* 提交的视频表单名称 */
        'videoPathFormat' => '/uploads/video/{yyyy}/{mm}{dd}/', /* 上传保存路径,可以自定义保存路径和文件名格式 */
        'videoFileName' => '{filename}',
        'videoUrlPrefix' => '', /* 视频访问路径前缀 */
        'videoMaxSize' => 102400000, /* 上传大小限制，单位B，默认100MB */
        'videoAllowFiles' => [
            '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg',
            '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid',], /* 上传视频格式显示 */

        /* 上传文件配置 */
        'fileActionName' => 'upload_file', /* controller里,执行上传视频的action名称 */
        'fileFieldName' => 'upfile', /* 提交的文件表单名称 */
        'filePathFormat' => '/uploads/file/{yyyy}/{mm}{dd}/', /* 上传保存路径,可以自定义保存路径和文件名格式 */
        'fileFileName' => '{filename}',
        'fileUrlPrefix' => '', /* 文件访问路径前缀 */
        'fileMaxSize' => 51200000, /* 上传大小限制，单位B，默认50MB */
        'fileAllowFiles' => [
            '.png', '.jpg', '.jpeg', '.gif', '.bmp',
            '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg',
            '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid',
            '.rar', '.zip', '.tar', '.gz', '.7z', '.bz2', '.cab', '.iso',
            '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.pdf', '.txt', '.md', '.xml',
        ], /* 上传文件格式显示 */

        /* 列出指定目录下的图片 */
        'imageManagerActionName' => 'list_image', /* 执行图片管理的action名称 */
        'imageManagerListPath' => '/uploads/image/', /* 指定要列出图片的目录 */
        'imageManagerListSize' => 20, /* 每次列出文件数量 */
        'imageManagerUrlPrefix' => '', /* 图片访问路径前缀 */
        'imageManagerInsertAlign' => 'none', /* 插入的图片浮动方式 */
        'imageManagerAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'], /* 列出的文件类型 */

        /* 列出指定目录下的文件 */
        'fileManagerActionName' => 'list_file', /* 执行文件管理的action名称 */
        'fileManagerListPath' => '/uploads/file/', /* 指定要列出文件的目录 */
        'fileManagerUrlPrefix' => '', /* 文件访问路径前缀 */
        'fileManagerListSize' => 20, /* 每次列出文件数量 */
        'fileManagerAllowFiles' => [
            '.png', '.jpg', '.jpeg', '.gif', '.bmp',
            '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg',
            '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid',
            '.rar', '.zip', '.tar', '.gz', '.7z', '.bz2', '.cab', '.iso',
            '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.pdf', '.txt', '.md', '.xml',
        ], /* 列出的文件类型 */
    ],
];
