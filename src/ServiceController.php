<?php


namespace ymlluo\Ueditor;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function serve(Request $request)
    {
//        return phpinfo();
        $ueditor = app('ueditor');
        $action = $request->get('action');
        if ($action == 'config') {
            return config('ueditor.upload_configs');
        }
        $actionKey = $ueditor->getNameByAction($action);
        switch ($actionKey) {
            case "imageActionName":
            case "scrawlActionName":
            case "snapscreenActionName":
            case "videoActionName":
            case "fileActionName":
                return $ueditor->upload($request);
                break;
            case "catcherActionName":
                break;
            case "imageManagerActionName":
                return $ueditor->listImages($request->get('start'),$request->get('size'));
                break;
            case "fileManagerActionName":
                return $ueditor->listFiles($request->get('start'),$request->get('size'));
                break;

        }

        if (Str::contains($action, 'upload')) {

        } else {
            return [];
        }

    }

}
