<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" integrity="sha256-Vzbj7sDDS/woiFS3uNKo8eIuni59rjyNGtXfstRzStA=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.css" integrity="sha256-p+PhKJEDqN9f5n04H+wNtGonV2pTXGmB4Zr7PZ3lJ/w=" crossorigin="anonymous">


    <title>素材管理</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-condensed table-striped">
                    <thead>
                    <tr>
                        <th scope="col">素材 ID</th>
                        <th scope="col">素材预览</th>
                        <th scope="col">素材名称</th>
                        <th scope="col">素材类型</th>
                        <th scope="col">文件大小</th>
                        <th scope="col">文件尺寸</th>
                        <th scope="col">创建时间</th>
                        <th scope="col">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr>
                            <th scope="row">{{$item->id}}</th>
                            {{--                        <td>{{$item->title}}</td>--}}
                            @switch($item->{'file_type'})
                                @case(\ymlluo\Ueditor\Models\UploadResource::FILE_TYPE_IMAGE)
                                <td>
                                    <a data-fancybox href="{{ $item->{'url'} }}"><img style="max-width: 100px;" class="img-responsive" src="{{$item->url}}"></a>
                                </td>
                                @break
                                @case(\ymlluo\Ueditor\Models\UploadResource::FILE_TYPE_VIDEO)
                                <td><a data-fancybox data-width="640" data-height="360" href="{{ $item->{'url'} }}">
                                        {{$item->title}}
                                    </a></td>

                                @break
                                @default
                                <td><a target="_blank" href="{{ $item->{'url'} }}">
                                        {{$item->title}}
                                    </a></td>
                                @break

                            @endswitch
                            <td>{{$item->title}}</td>
                            <td class="text-center">{{$item->file_type_name}}</td>
                            <td class="text-center">{{$item->file_size}}</td>
                            <td class="text-center">@if($item->width){{$item->width}}*{{$item->height}} @else N/A @endif</td>

                            <td>{{$item->created_at}}</td>
                            <td>
                                <button class="btn btn-primary btn-sm btn-copy" data-content="{{$item->url}}">复制链接
                                </button>
                            </td>
                        </tr>
                    @empty
                    @endforelse


                    </tbody>
                </table>
            </div>
            <div>
                {!! $items->links() !!}
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js" integrity="sha256-yt2kYMy0w8AbtF89WXb2P1rfjcP/HTHLT7097U8Y5b8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.min.js" integrity="sha256-ITwLtH5uF4UlWjZ0mdHOhPwDpLoqxzfFCZXn1wE56Ps=" crossorigin="anonymous"></script>
<script>
    function copyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.style.position = 'fixed';
        textArea.style.top = 0;
        textArea.style.left = 0;
        textArea.style.width = '2em';
        textArea.style.height = '2em';
        textArea.style.padding = 0;
        textArea.style.border = 'none';
        textArea.style.outline = 'none';
        textArea.style.boxShadow = 'none';
        textArea.style.background = 'transparent';
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        var successful = false;
        try {
            successful = document.execCommand('copy');
        } catch (err) {
            successful = false

        }
        document.body.removeChild(textArea);
        return successful;
    }

    $(function () {
        $('body').off('click', '.btn-copy').on('click', '.btn-copy', function () {
            var text = $(this).attr('data-content');
            copyTextToClipboard(text);
            new Noty({
                text: 'Copy Success',
                timeout: 100,
                layout: 'center',
                type: 'info',
                progressBar: false,

            }).show();

        })
    })
</script>
</body>
</html>
