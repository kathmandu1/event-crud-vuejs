<?php

namespace App\Facades ;

use Carbon\Carbon;

class FilterEvent
{

    public function __construct()
    {
        // $this->carbon = $carbon ;
    }

    /**
     * this member function is responsible for return from and to date
     * scenerio considers ----Finished events, Upcoming events, Upcoming events
     *  within 7 days, Finished events of the last 7 days.
     * @params $filterType => what type of date
     * @return Array 
     */
    public function findDayDiff( String $filterType ) : Array
    {
        $carbon = new Carbon();
        $dateFrom = null ;
        $dateTo = null ;
        $filterFrom = null ;
        switch ($filterType){
            case  "Last Week" :
                $dateFrom = $carbon->now()->subDays(7);
                $dateTo= $carbon->now();
                $filterFrom = "before" ;
                break ;
            case "Finished" :
                
                $dateTo= $carbon->now();
                $filterFrom = "before" ;
                break ;
            case "Comming" :
                $dateFrom= $carbon->now();
                $filterFrom = "after" ;
                break ;
            case "Comming Week" :
                $dateTo = $carbon->now()->addDays(7);
                $dateFrom= $carbon->now();
                $filterFrom = "after" ;
                break ;
        }
        return [
            'from_date' => $dateFrom ,
            'to_date' => $dateTo ,
            'filter_type' =>  $filterFrom,
        ];
        
    }
}