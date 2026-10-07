<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class AuthSessionRegenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_login_regenerates_the_session_id(): void
    {
        $googleUser = (new SocialiteUser)->map([
            'id' => 'google-session-test',
            'name' => 'Google User',
            'email' => 'google-session@example.com',
            'avatar' => null,
        ]);

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')->once()->andReturn($googleUser);
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->withSession(['google_login_probe' => true]);
        $sessionIdBeforeLogin = app('session.store')->getId();

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('home'));

        $this->assertNotSame($sessionIdBeforeLogin, app('session.store')->getId());
        $this->assertDatabaseHas('users', ['email' => 'google-session@example.com']);
    }
}
