<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
        if (env('APP_DEBUG')){
            Log::info($request->getUri());

            DB::enableQueryLog();
        }
    }

    public function __destruct()
    {

        if (env('APP_DEBUG')){
            $queriesWithBindings = [];

            foreach (DB::getQueryLog() as $key => $queryInfo) {
                $queriesWithBindings[$key]['query'] = vsprintf(str_replace('?', '%s', $queryInfo['query']), collect($queryInfo['bindings'])->map(function ($binding) {
                    return is_numeric($binding) ? $binding : "'{$binding}'";
                })->toArray());

                $queriesWithBindings[$key]['time'] = $queryInfo['time'] . ' msec';
            }

            foreach ($queriesWithBindings as $queryLog) {
                Log::info('query -> ' . $queryLog['query'] . ';');
                Log::info('time -> ' . $queryLog['time'] . ' ms;');
            }

            Log::info('  ');
        }
    }
}
