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


    <title>{{__('ueditor::lang.resource_manager')}}</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered table-condensed table-striped">
                    <thead>
                    <tr>
                        <th scope="col">{{__('ueditor::lang.id')}}</th>
                        <th scope="col">{{__('ueditor::lang.preview')}}</th>
                        <th scope="col">{{__('ueditor::lang.title')}}</th>
                        <th scope="col">{{__('ueditor::lang.res_type')}}</th>
                        <th scope="col">{{__('ueditor::lang.res_size')}}</th>
                        <th scope="col">{{__('ueditor::lang.res_w_h')}}</th>
                        <th scope="col">{{__('ueditor::lang.created_at')}}</th>
                        <th scope="col">{{__('ueditor::lang.operation')}}</th>
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
                                    <a data-fancybox href="{{ $item->{'url'} }}"><img style="max-width: 42px;" class="img-responsive" src="{{$item->url}}"></a>
                                </td>
                                @break
                                @case(\ymlluo\Ueditor\Models\UploadResource::FILE_TYPE_VIDEO)
                                <td><a data-fancybox data-width="640" data-height="360" href="{{ $item->{'url'} }}">
                                        {{__('ueditor::lang.preview')}}
                                    </a></td>

                                @break
                                @default
                                <td><a target="_blank" href="{{ $item->{'url'} }}">
                                        {{__('ueditor::lang.download')}}
                                    </a></td>
                                @break

                            @endswitch
                            <td>{{$item->title}}</td>
                            <td class="text-center">{{$item->file_type_name}}</td>
                            <td class="text-center">{{$item->file_size}}</td>
                            <td class="text-center">@if($item->width){{$item->width}}*{{$item->height}} @else N/A @endif</td>

                            <td>{{$item->created_at}}</td>
                            <td>
                                <button class="btn btn-primary btn-sm btn-res-copy" data-content="{{$item->url}}">{{__('ueditor::lang.copy_url')}}</button>
                                <a href="{{route('resource.manager.destroy',$item->id)}}" class="btn btn-sm btn-danger btn-res-destroy ">{{__('ueditor::lang.delete')}}</a>
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


<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
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
    function notify_msg($msg,$type = 'info'){
        new Noty({
            text: $msg,
            timeout: 100,
            layout: 'center',
            type: $type,
            progressBar: false,

        }).show();

    }

    $(function () {
        $('body').off('click', '.btn-res-copy').on('click', '.btn-res-copy', function () {
            var text = $(this).attr('data-content');
            copyTextToClipboard(text);
            notify_msg('Copy Success')

        }).off('click', '.btn-res-destroy').on('click', '.btn-res-destroy', function () {
            var url = $(this).attr('href');
            var tr = $(this).closest('tr');
            if (confirm('confirm delete ?')){
                $.post(url,{'_method':"DELETE"}).done(function (response) {
                    console.log(response);
                    if (response.data.result){
                        tr.remove();
                    }else {
                        notify_msg('delete failed!')
                    }
                })
            }


            return false;

        })
    })
</script>
</body>
</html>
