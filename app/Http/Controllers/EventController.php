<?php

namespace App\Http\Controllers;

use App\Facades\EventFilterFacade;
use App\Helpers\FilterEvent;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\Contracts\EventContract;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * dependency injection for Event controller, instance are 
     * available to all member method for this Event class
     * @param EventContract and Carbon instance
     */
    public function __construct(EventContract $eventContract, Carbon $carbon)
    {
        $this->eventContract = $eventContract;
        $this->carbon = $carbon ;
    }

    /**
     * this memeber function return the list of event
     * @param Request = null  for search and filter
     * all filter from different cases were comes to this method
     * EventFilterFacade facade have logic for last week , comming week and finish data
     * @return ResourceResponse 
     */
    public function index(Request $request)
    {
        try{
            $filterData = $request ;
            if($request->has('date')){
               $eventFilterRequest =  EventFilterFacade::findDayDiff($request->date);
                $filterData = $request->merge($eventFilterRequest);
            }
            $events = $this->eventContract->getEventtList($filterData, null) ;
        }catch(Exception $e)
        {
            return response(['error' => $e->getMessage()], 500);
        }
        return EventResource::collection($events);
    }

    /**
     * this memeber function save event into storage
     * @param Request  for store attributes
     * @return Response in 201 status 
     */
    public function store(EventStoreRequest $request)
    {
        try{
            DB::beginTransaction();
            $customeRequestItems = new Request([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $this->carbon->parse($request->start_date),
                'end_date' => $this->carbon->parse($request->end_date) ,
            ]);
            $events = $this->eventContract->storeEvent($customeRequestItems) ;
            dd($events);
        }catch(Exception $e)
        {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 500);
        }
        DB::commit();
        return new EventResource($events);
    }

    /**
     * this memeber function  update event tostorage
     * @param Request  for update attributes
     * @return Response in 201 status 
     */
    public function update(Request $request, int $id)
    {
        try{
            DB::beginTransaction();
            $customeRequestItems = new Request([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $this->carbon->parse($request->start_date),
                'end_date' => $this->carbon->parse($request->end_date) ,
            ]);
            $eventUpdate = $this->eventContract->updateEvent($customeRequestItems, $id) ;
          
        }catch(Exception $e)
        {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 500);
        }
        DB::commit();
        return new EventResource($eventUpdate);
    }

    /**
     * this memeber function  delete event from storage
     * @param  Type Hinting EventId  for delete modal
     * @return Response in 204 status 
     */
    public function destroy(Event $event)
    {
        try{
            DB::beginTransaction();
            $events = $this->eventContract->deleteEvent($event) ;
        }catch(Exception $e)
        {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 500);       
        }
        DB::commit();
        return response(['message' => 'successfully deleted a event'],204);
    }
}
