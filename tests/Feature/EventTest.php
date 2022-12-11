<?php

namespace Tests\Feature;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test for api list getting on listed structure or not
     */
    public function test_event_list_get()
    {
        $this->json('GET', route('events.index'))
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'start_date',
                            'end_date',
                        ],

                    ]
                ]
            );
    }

    /**
     * test for api data store to database or not
     */
    public function test_event_store_to_database()
    {
        $eventPayload =   [
            'title' => 'title from test case',
            'description' => 'description from test case',
            'start_date' => '2022-10-25',
            'end_date' => '2022-10-30',
        ];
        $this->json('POST', route('events.store'), $eventPayload)
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'events' => [
                        'id',
                        'title',
                        'description',
                        'start_date',
                        'end_date',
                    ],
                ]
            );
    }
    /**
     * test for api data update to database
     */
    public function test_event_update_to_database()
    {
        $event = Event::factory()->create();
        $updatePayload =   [
            'title' => 'title from test case',
            'description' => 'description from test case',
            'start_date' => '2022-10-25',
            'end_date' => '2022-10-30',
        ];
        $this->json('PATCH', route('events.update', [$event->id]),$updatePayload )
            ->assertStatus(204);

    }

    /**
     * test for api data delete to database
     */
    public function test_event_delete_from_database()
    {
        $eventPayload = Event::factory()->create();
        $this->json('DELETE', route('events.destroy',[ $eventPayload->id]))
            ->assertStatus(204);
    }

    /**
     * test for api event list from last week
     */
    public function test_event_get_list_of_last_week_event()
    {
        $event = Event::factory()->create([
            'start_date' => Carbon::now()->subDay(6),
            'end_date' => Carbon::now()->subDay(3)
        ]);

        $payload = [
            'date' => 'Last Week',
        ];
        $response = $this->json('GET', route('events.index'),$payload);
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'start_date',
                            'end_date',
                        ],

                    ]
                ]
            );
    }

    /**
     * test for api for finished event
     */
    public function test_event_get_list_of_finished_event()
    {
        $event = Event::factory()->create([
            'start_date' => Carbon::now()->subDay(10),
            'end_date' => Carbon::now()->subDay(6)
        ]);

        $payload = [
            'date' => 'Finished',
        ];
        $response = $this->json('GET', route('events.index'),$payload);
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'start_date',
                            'end_date',
                        ],

                    ]
                ]
            );
    }

    /**
     * test for api for all comming event
     */
    public function test_event_get_list_of_comming_event()
    {
        $event = Event::factory()->create([
            'start_date' => Carbon::now()->addDay(2),
            'end_date' => Carbon::now()->addDay(6)
        ]);

        $payload = [
            'date' => 'Comming',
        ];
        $response = $this->json('GET', route('events.index'),$payload);
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'start_date',
                            'end_date',
                        ],

                    ]
                ]
            );
    }

    /**
     * test for api for comming week event
     */
    public function test_event_get_list_of_comming__week_event()
    {
        $event = Event::factory()->create([
            'start_date' => Carbon::now()->addDay(2),
            'end_date' => Carbon::now()->addDay(6)
        ]);

        $payload = [
            'date' => 'Comming',
        ];
        $response = $this->json('GET', route('events.index'),$payload);
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'start_date',
                            'end_date',
                        ],

                    ]
                ]
            );
    }

}
