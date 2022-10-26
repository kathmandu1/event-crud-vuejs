<?php

namespace App\Services\Contracts ;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

interface EventContract
{
    public function getEventtList(Request $request = null) : Collection;
    public function storeEvent(Request $request) : Model ;
    public function deleteEvent($id) : bool;
    public function updateEvent(Request $request, $id): Model;
    // public function findEvent($id) 
}
