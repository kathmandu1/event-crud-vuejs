<?php

namespace App\Services\Repositories ;

use App\Models\Event;
use App\Services\Contracts\EventContract;
use App\Services\Repositories\Pipelines\QueryFilters\DateFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Request;

class EventService implements EventContract
{
    public function __construct(Event $event)
    {
        $this->event = $event ;
    }

    public function getEventtList($request = null) : Collection
    { 
        $events = app(Pipeline::class)
            ->send($this->event->query())
            ->through([
                DateFilter::class  ,
            ])
            ->thenReturn() ;
        // $request->has('limit') ? $permissionModulePipeline->paginate($request->limit)  :
        return $events->get() ;
                
    }

    public function storeEvent($request) : Model
    { 

        $event = $this->event->create($request->all());
        return $event ;
    }

    public function deleteEvent($id) : bool
    {
        return $this->event->findOrFail($id)->delete();
        
    }

    public function updateEvent($request,  $id): Model
    {
        $event = $this->updateOrCreate($request->all(), $id);
        return $event ;
    }

    public function updateOrCreate($request, $id = null)
    {
        $event  =  $this->event->updateOrCreate([
            'id' => $id
        ], $request);
        return $event ;
    }

}
