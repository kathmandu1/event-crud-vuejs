<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginRequstTest extends TestCase
{
    /** @test */
    public function test_should_not_authorize_the_request_non_login()
    {
        Auth::shouldReceive('check')
            ->once()
            ->andReturn(false);
        $request = new LoginRequest();
        $this->assertFalse($request->authorize());
    }

    /** @test */
    public function test_should_not_authorize_the_request_login()
    {
        Auth::shouldReceive('check')
            ->once()
            ->andReturn(true);
        $request = new LoginRequest();
        $this->assertTrue($request->authorize());
    }
    /** @test */
    public function test_contain_all_the_expected_validation_rules()
    {
        $request = new LoginRequest();

        $this->assertEquals([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
        ], $request->rules());
    }
}
