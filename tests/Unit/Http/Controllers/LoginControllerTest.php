<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\LoginController;
use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    /**
     * test return view or not
     */
    public  function  test_login_redirect_to_login_page() : void
    {
        $login = new LoginController();
        $user  = User::factory()->create();
        $this->actingAs($user);
        $response = $login->login();
//        dd($response->getName());
        $this->assertEquals('login', $response->getName());
    }



}
