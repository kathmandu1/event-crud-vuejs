<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\AuthMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthMiddleWareTest extends  TestCase
{

    public  function  test_user_is_authenticate()
    {
//        $user  = User::factory()->create();
//        $this->actingAs($user);
//        $request = Request::create('/login', 'GET');
//        $middleware = new AuthMiddleware();
//        $response = $middleware->handle($request, function () {});
//        $this->assertEquals($response->getStatusCode(), 302);
    }

    //test login route has middleware - test cases
}
