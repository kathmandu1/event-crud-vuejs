<?php

namespace App\Services\Repositories\Pipelines\QueryFilters ;

use Closure;

class DateFilter
{
    public function handle($request, Closure $next, ...$remove)
    {
        if (!request()->has('filter_type')) {
            return $next($request);
        }

        //code for finished event
        $fillter =   $next($request)->when(!is_null(request()->to_date) && is_null(request()->from_date), function($query){
            $query->where('end_date',  '<' ,request()->to_date);
        } );

        //code for comming  event
        $fillter =   $next($request)->when(is_null(request()->to_date) && !is_null(request()->from_date), function($query){
            $query->where('start_date',  '>' ,request()->from_date);
        } ) ;

        //code for event having from and to date
        $fillter =   $next($request)->when(!is_null(request()->to_date) && !is_null(request()->from_date), function($query){
            if(request()->filter_type == "before"){
            
                $query->whereBetween('end_date', [request()->from_date, request()->to_date]);
            }
            if(request()->filter_type == "after"){
                $query->whereBetween('start_date', [request()->from_date, request()->to_date]);
            }
            
        } ) ;
        return $fillter ;

    }
}