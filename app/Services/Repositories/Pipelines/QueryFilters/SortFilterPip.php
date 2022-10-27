<?php

namespace App\Services\Repositories\Pipelines\QueryFilters ;

use Closure;

class SortFilterPip
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('sort')) {
            return $next($request);
        }
        return $next($request)->orderBy( request()->sortcolumn, request()->sort );

    }
}
