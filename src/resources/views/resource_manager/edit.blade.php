<form class="form-horizontal" action="{{route('resource.manager.store')}}">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="res-edit-dialog-title">{{__('ueditor::lang.edit')}}</h5>
        </div>
        <div class="modal-body">
            <div id="res-edit-dialog-content">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">{{__('ueditor::lang.title')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" autocomplete="off" value="{{$item->title}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-control-label col-sm-3">{{__('ueditor::lang.resource_type')}} </label>
                        <div class="col-sm-9">
                            @foreach($fileTypes as $k=>$v)
                                <div class="form-check form-check-inline small">
                                    <input class="form-check-input" type="radio" name="file_type" {{$v['checked']?'checked':''}} id="res-edit-type-{{$k}}" value="{{$k}}">
                                    <label class="form-check-label" for="res-edit-type-{{$k}}">{{$v['name']}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                <input type="hidden" name="id" value="{{$item->id}}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-edit-store-cancel" data-dismiss="modal">{{__('ueditor::lang.cancel')}}</button>
            <button type="submit" class="btn btn-primary btn-edit-store-ok">{{__('ueditor::lang.ok')}}</button>
        </div>
    </div>
</div>
</form>
