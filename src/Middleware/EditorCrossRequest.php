<?php

namespace ymlluo\Ueditor\Middleware;

use Closure;

class EditorCrossRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cors = config('ueditor.route.cors');
        if (!$cors) {
            return $next($request);
        }
        if ($cors == '*') {
            header('Access-Control-Allow-Origin: *');
        }
        if (is_array($cors)) {
            $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
            if (in_array($origin, $cors)) {
                header('Access-Control-Allow-Origin: ' . $origin . '');
            }
        }
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type,Access-Token");
        header("Access-Control-Expose-Headers: *");
        return $next($request);
    }
}
