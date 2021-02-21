<?php


namespace App\Http\Middleware;

use Yao\Contracts\Middleware;
use Yao\Facade\Cache;

class Statistic implements Middleware
{
    public function handle($request, \Closure $next)
    {

//        echo ('dd');
        try {
            $stat = (int)Cache::get('stat');
            Cache::set('stat', ++$stat);
        } catch (\Exception $e) {
            $stat = 0;
        }
        $response = $next($request);
//        echo 'fs';
        return $response;
    }

}