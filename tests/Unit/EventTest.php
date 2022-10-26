<?php

namespace Tests\Unit;

use App\Http\Controllers\EventController;
use App\Http\Requests\EventStoreRequest;
use App\Services\Contracts\EventContract;
use App\Services\Repositories\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_event_list()
    {
        $event = $this->createMock(EventContract::class);
        $carbon = $this->createMock(Carbon::class);
        $some_controller = new EventController($event , $carbon);
        $request =  $this->createMock(Request::class, function ($mock) {
            $mock->shouldReceive('passes')->andReturn(true);
        });

        $event = $some_controller->index($request);
        $this->assertTrue(true);
    }

    // public function test_store_event()
    // {
    //     $event = $this->createMock(EventContract::class);
    //     $carbon = $this->createMock(Carbon::class);
    //     $some_controller = new EventController($event , $carbon);
    //     // $request =  $this->createMock(EventStoreRequest::class, function ($mock) {
    //     //     $mock->shouldReceive('passes')->andReturn(true);
    //     // });
    //     $request =  $this->createMock(EventStoreRequest::class);

    //     $event = $some_controller->store($request);
    //     $this->assertTrue(true);
    // }
}
