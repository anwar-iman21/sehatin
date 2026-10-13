<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_session_endpoint_returns_a_fresh_csrf_token_without_caching_it(): void
    {
        $this->get(route('register.session'))
            ->assertOk()
            ->assertJsonStructure(['token'])
            ->assertHeader('Cache-Control', 'no-store, private');
    }

    public function test_password_confirmation_error_is_shown_by_the_confirmation_field_in_indonesian(): void
    {
        $response = $this->withSession(['locale' => 'id'])
            ->from(route('register'))
            ->post(route('register'), [
                'name' => 'Pengguna Baru',
                'email' => 'baru@example.com',
                'password' => 'password123',
                'password_confirmation' => 'different123',
            ]);

        $response->assertRedirect(route('register'))
            ->assertSessionHasErrors('password_confirmation');

        $this->get(route('register'))
            ->assertSee('Konfirmasi kata sandi tidak sama dengan kata sandi.')
            ->assertSee('aria-invalid="true"', false);

        $this->assertDatabaseMissing('users', ['email' => 'baru@example.com']);
    }

    public function test_duplicate_email_error_identifies_the_email_field(): void
    {
        User::factory()->create(['email' => 'ada@example.com']);

        $this->withSession(['locale' => 'id'])
            ->from(route('register'))
            ->post(route('register'), [
                'name' => 'Pengguna Baru',
                'email' => 'ada@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('email');

        $this->get(route('register'))
            ->assertSee('Alamat email ini sudah terdaftar.')
            ->assertSee('id="email-error"', false);
    }

    public function test_password_length_error_is_shown_by_the_password_field(): void
    {
        $this->withSession(['locale' => 'id'])
            ->from(route('register'))
            ->post(route('register'), [
                'name' => 'Pengguna Baru',
                'email' => 'baru@example.com',
                'password' => 'short',
                'password_confirmation' => 'short',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('password');

        $this->get(route('register'))
            ->assertSee('Kata sandi minimal 8 karakter.')
            ->assertSee('id="password-error"', false);
    }

    public function test_registration_rejects_names_with_more_than_two_words(): void
    {
        $this->withSession(['locale' => 'id'])
            ->from(route('register'))
            ->post(route('register'), [
                'name' => 'Nama Pengguna Baru',
                'email' => 'baru@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseMissing('users', ['email' => 'baru@example.com']);
    }

    public function test_user_can_register_with_matching_password_confirmation(): void
    {
        $this->withSession(['registration_probe' => true]);
        $sessionIdBeforeRegistration = app('session.store')->getId();

        $this->withSession(['locale' => 'id'])
            ->post(route('register'), [
                'name' => 'Pengguna Baru',
                'email' => 'baru@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', ['email' => 'baru@example.com']);
        $this->assertNotSame($sessionIdBeforeRegistration, app('session.store')->getId());
    }
}
