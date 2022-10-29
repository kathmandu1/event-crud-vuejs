<?php

namespace App\Services\Contracts ;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface EventContract
{
    public function getEventtList(Request $request = null, int $paginationPerPage = null);
    public function storeEvent(Request $request) : Model ;
    public function deleteEvent(Event $id) : bool;
    public function updateEvent(Request $request, int $id): Model;
}
