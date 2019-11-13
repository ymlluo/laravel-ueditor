<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" integrity="sha256-Vzbj7sDDS/woiFS3uNKo8eIuni59rjyNGtXfstRzStA=" crossorigin="anonymous">


    <title>素材管理</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered table-condensed table-striped">
                <thead>
                <tr>
                    <th scope="col">素材 ID</th>
                    <th scope="col">素材名称</th>
                    <th scope="col">素材预览</th>
                    <th scope="col">创建时间</th>
                    <th scope="col">操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->original}}</td>
                        <td><a href="#" class="media-type-{{$item->file_type}}">{{$item->url}}</a></td>
                        <td>@{{$item->id}}</td>
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/popper.min.js" integrity="sha256-trs1NroMTXyZS9LeGSSGjIWW3EKTGqAbWaYR5iSVMyQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js" integrity="sha256-yt2kYMy0w8AbtF89WXb2P1rfjcP/HTHLT7097U8Y5b8=" crossorigin="anonymous"></script>
</body>
</html>
