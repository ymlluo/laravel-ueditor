<?php

namespace ymlluo\Ueditor\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ymlluo\Ueditor\Models\UploadResource;

class ResourceManagerController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $size = intval(\request()->get('size', 15));
        $title = trim(\request()->get('title'));
        $file_types = array_map('intval', (array)\request()->get('file_type'));
        $items = UploadResource::query()
            ->when($title, function ($sql) use ($title) {
                $sql->where('title', 'like', '%' . $title . '%');
            })
            ->when($file_types, function ($sql) use ($file_types) {
                $sql->whereIn('file_type', $file_types);
            })
            ->orderByDesc('id')->paginate($size);

        $fileTypes = (new UploadResource)->fileTypeMaps();
        foreach ($fileTypes as $k => &$arr) {
            $arr['checked'] = in_array($k, $file_types) ? true : false;
        }
        return view('ueditor::resource_manager.index')->with(compact('items', 'fileTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = UploadResource::query()->findOrFail($id);
        $path = $res->{'path'};
        $ueditor = app('ueditor');
        if ($result = $ueditor->deleteResource($path)) {
            $res->delete();
        }
        return response()->json(['code' => 200, 'data' => ['result' => $result]]);
    }
}
