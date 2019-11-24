<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" integrity="sha256-Vzbj7sDDS/woiFS3uNKo8eIuni59rjyNGtXfstRzStA=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.css" integrity="sha256-p+PhKJEDqN9f5n04H+wNtGonV2pTXGmB4Zr7PZ3lJ/w=" crossorigin="anonymous">


    <title>{{trans('ueditor::lang.resource_manager')}}</title>
</head>
<body>
<div class="container">

    <form class="form-horizontal border rounded p-3 my-3 ">
        <h3 class="text-center text-black-50">{{trans('ueditor::lang.resource_manager')}}</h3>
        <div class="form-group row">
            <label class="col-control-label col-sm-2">{{trans('ueditor::lang.title')}} </label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="title" autocomplete="off" value="{{request('title')}}">
            </div>

        </div>
        <div class="form-group row">
            <label class="col-control-label col-sm-2">{{trans('ueditor::lang.resource_type')}} </label>
            <div class="col-sm-8">
                @foreach($fileTypes as $k=>$v)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="file_type[]" {{$v['checked']?'checked':''}} id="res-type-{{$k}}" value="{{$k}}">
                        <label class="form-check-label" for="res-type-{{$k}}">{{$v['name']}}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary"><i class="fa fa-search"></i> {{trans('ueditor::lang.search')}}</button>
        </div>

    </form>
    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered table-condensed">
            <thead>
            <tr>
                <th scope="col">{{trans('ueditor::lang.id')}}</th>
                <th scope="col">{{trans('ueditor::lang.preview')}}</th>
                <th scope="col">{{trans('ueditor::lang.title')}}</th>
                <th scope="col">{{trans('ueditor::lang.res_type')}}</th>
                <th scope="col">{{trans('ueditor::lang.res_size')}}</th>
                <th scope="col">{{trans('ueditor::lang.res_w_h')}}</th>
                <th scope="col">{{trans('ueditor::lang.created_at')}}</th>
                <th scope="col">{{trans('ueditor::lang.operation')}}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    @if($item->file_type == 200)
                        <td>
                            <a data-fancybox href="{{ $item->{'url'} }}"><img style="max-width: 42px;" class="img-responsive" src="{{$item->url}}"></a>
                        </td>
                    @elseif($item->file_type == 400)
                        <td><a data-fancybox data-width="640" data-height="360" href="{{ $item->{'url'} }}">
                                {{__('ueditor::lang.preview')}}
                            </a></td>
                    @else
                        <td><a target="_blank" href="{{ $item->{'url'} }}">
                                {{__('ueditor::lang.download')}}
                            </a></td>
                    @endif
                    <td>
                        <button class="btn btn-sm btn-link  btn-res-copy" data-toggle="tooltip" title="{{trans('ueditor::lang.copy_url')}}" data-content="{{$item->url}}">{{$item->title}}</button>
                    </td>
                    <td class="text-center">{{$item->file_type_name}}</td>
                    <td class="text-center">{{$item->file_size}}</td>
                    <td class="text-center">@if($item->width){{$item->width}}*{{$item->height}} @else N/A @endif</td>

                    <td>{{$item->created_at}}</td>
                    <td>
                        <a class="btn btn-sm btn-outline-info btn-res-edit" data-toggle="tooltip" title="{{trans('ueditor::lang.edit')}}" href="{{route('resource.manager.edit',$item->id)}}"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-sm btn-outline-danger btn-res-destroy" data-toggle="tooltip" title="{{trans('ueditor::lang.delete')}}" href="{{route('resource.manager.destroy',$item->id)}}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @empty
            @endforelse


            </tbody>
        </table>
    </div>
    <div>
        {!! $items->appends(request()->except(['page']))->render() !!}
    </div>
</div>
<div class="modal fade" id="confirm-dialog-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-dialog-title"></h5>
            </div>
            <div class="modal-body">
                <div id="confirm-dialog-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-confirm-cancel" data-dismiss="modal">{{trans('ueditor::lang.cancel')}}</button>
                <button type="button" class="btn btn-primary btn-confirm-ok">{{trans('ueditor::lang.ok')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="res-edit-dialog-modal" tabindex="-1" role="dialog" aria-hidden="true"></div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha256-x3YZWtRjM8bJqf48dFAv/qmgL68SI4jqNWeSLMZaMGA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js" integrity="sha256-yt2kYMy0w8AbtF89WXb2P1rfjcP/HTHLT7097U8Y5b8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.min.js" integrity="sha256-ITwLtH5uF4UlWjZ0mdHOhPwDpLoqxzfFCZXn1wE56Ps=" crossorigin="anonymous"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/ionicons@4.6.3/dist/ionicons.js" integrity="sha256-nO3ric+gFl0JC4umpii+10rqFL5PL7oQ0OBCOXdVh00=" crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.11.2/js/all.min.js" integrity="sha256-qM7QTJSlvtPSxVRjVWNM2OfTAz/3k5ovHOKmKXuYMO4=" crossorigin="anonymous"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    function notify_msg($msg, $type = 'info') {
        new Noty({
            text: $msg,
            timeout: 500,
            layout: 'center',
            type: $type,
            progressBar: false,

        }).show();

    }


    $(function () {
        $('.pagination li').each(function () {
            if(! $(this).hasClass('page-item')){
                $(this).addClass('page-item').find('a,span').addClass('page-link')
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
        $('body').off('click', '.btn-res-copy').on('click', '.btn-res-copy', function () {
            var text = $(this).attr('data-content');
            copyTextToClipboard(text);
            notify_msg('Copy Success')

        }).off('click', '.btn-res-destroy').on('click', '.btn-res-destroy', function () {
            var url = $(this).attr('href');
            var tr = $(this).closest('tr');
            var $modal = $('#confirm-dialog-modal');
            $('#confirm-dialog-title').text('{{trans('ueditor::lang.res_confirm_delete_title')}}');
            $('#confirm-dialog-content').text('{{trans('ueditor::lang.res_confirm_delete_warning')}}');
            $modal.modal();
            $('.btn-confirm-ok').off('click').on('click', function () {
                $.post(url, {'_method': "DELETE"}).done(function (response) {
                    console.log(response);
                    if (response.data.result) {
                        tr.remove();
                        notify_msg('{{trans('ueditor::lang.delete_success')}}')
                    } else {
                        notify_msg('{{trans('ueditor::lang.delete_failed')}}')
                    }
                });
                $modal.modal('hide');
            });


            return false;

        }).off('click','.btn-res-edit').on('click','.btn-res-edit',function () {
            var url = $(this).attr('href');
            var editModal = $('#res-edit-dialog-modal');
            $.get(url).done(function (response) {
                console.log(response);
                editModal.html(response).modal('show');
                $('.btn-edit-store-ok').click(function () {
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    $.post(url,form.serialize()).done(function (response) {
                        if (response.code == 200){
                            editModal.modal('hide');
                        }
                        notify_msg(response.msg)
                    });
                    return false;

                })
            });
            return false;
        })
    })
</script>
</body>
</html>
