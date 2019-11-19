<form class="form-horizontal">
    <div class="form-group row">
        <label class="col-form-label col-sm-3"></label>
        <div class="col-sm-9">
            <input type="text" name="title" class="form-control" autocomplete="off" value="{{$item->title}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-control-label col-sm-2">{{__('ueditor::lang.resource_type')}} </label>
        <div class="col-sm-8">
            @foreach($fileTypes as $k=>$v)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="file_type[]" {{$v['checked']?'checked':''}} id="res-type-{{$k}}" value="{{$k}}">
                    <label class="form-check-label" for="res-type-{{$k}}">{{$v['name']}}</label>
                </div>
            @endforeach
        </div>
    </div>
</form>
