<?php

namespace App\Http\Controllers;

use App\Facades\EventFilterFacade;
use App\Helpers\FilterEvent;
use App\Http\Resources\EventResource;
use App\Services\Contracts\EventContract;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(EventContract $eventContract, Carbon $carbon)
    {
        $this->eventContract = $eventContract;
        $this->carbon = $carbon ;
    }

    public function index(Request $request)
    {
        try{
            $filterData = null ;
            if($request->has('date')){
               $eventFilterRequest =  EventFilterFacade::findDayDiff($request->date);
                $filterData = $request->merge($eventFilterRequest);
            }
            $events = $this->eventContract->getEventtList($filterData) ;
        }catch(Exception $e)
        {
            return response(['error' => $e->getMessage()], 500);
        }
        return EventResource::collection($events);
    }

    public function store(Request $request)
    {
        try{
            
            $customeRequestItems = new Request([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $this->carbon->parse($request->start_date),
                'end_date' => $this->carbon->parse($request->end_date) ,
            ]);
            $events = $this->eventContract->storeEvent($customeRequestItems) ;
        }catch(Exception $e)
        {
            return response(['error' => $e->getMessage()], 500);
        }
        return new EventResource($events);
    }

    public function update(Request $request, $id)
    {
        try{
            $customeRequestItems = new Request([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $this->carbon->parse($request->start_date),
                'end_date' => $this->carbon->parse($request->end_date) ,
            ]);
            $eventUpdate = $this->eventContract->updateEvent($customeRequestItems, $id) ;
          
        }catch(Exception $e)
        {
            return response(['error' => $e->getMessage()], 500);
        }
        return new EventResource($eventUpdate);
    }

    public function destroy($id)
    {
        try{
            $events = $this->eventContract->deleteEvent($id) ;
        }catch(Exception $e)
        {
            return response(['error' => $e->getMessage()], 500);       
        }
        return response(['message' => 'successfully deleted a event'],204);
    }
}
