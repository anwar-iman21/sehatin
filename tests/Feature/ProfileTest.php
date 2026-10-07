<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_and_update_profile_and_replace_avatar(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['avatar' => 'avatars/old.jpg']);
        Storage::disk('public')->put('avatars/old.jpg', 'old avatar');

        $this->actingAs($user)->get(route('profile.index'))->assertOk();
        $this->actingAs($user)->get(route('profile.edit'))->assertOk();
        $this->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'avatar' => UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg'),
        ])->assertRedirect(route('profile.index'));

        $user->refresh();
        $this->assertSame('Nama Baru', $user->name);
        $this->assertStringStartsWith('avatars/', $user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
        Storage::disk('public')->assertMissing('avatars/old.jpg');
    }

    public function test_user_can_change_password_only_with_the_correct_current_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('old-password')]);
        $this->actingAs($user);

        $this->put(route('profile.password'), [
            'current_password' => 'incorrect',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertSessionHasErrors('current_password');

        $this->put(route('profile.password'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('profile.edit'));

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_google_user_cannot_change_password(): void
    {
        $user = User::factory()->create([
            'google_id' => 'google-user-id',
            'password' => null,
        ]);

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertDontSee('Ganti Password');

        $this->put(route('profile.password'), [
            'current_password' => 'anything',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('profile.edit'))
            ->assertSessionHas('error');
    }

    public function test_admin_can_view_and_update_profile_and_password(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('old-password'),
            'avatar' => 'avatars/admin-profile.jpg',
        ]);
        $this->actingAs($admin);

        $this->get(route('admin.profile.index'))
            ->assertOk()
            ->assertSeeHtml('<title>SEHATIN</title>')
            ->assertSeeHtml('<link rel="icon" type="image/svg+xml" href="http://localhost:8000/favicon.svg">')
            ->assertSee('storage/avatars/admin-profile.jpg')
            ->assertSeeHtml('alt="Avatar ' . $admin->name . '"')
            ->assertSeeHtml('class="lang-toggle"')
            ->assertSeeHtml('class="lang-option lang-option--id active"')
            ->assertSeeHtml('class="btn btn-sm btn-danger"')
            ->assertSeeHtml('fas fa-globe');
        $this->get(route('admin.profile.edit'))->assertOk();

        $this->put(route('admin.profile.update'), ['name' => 'Admin Baru'])
            ->assertRedirect(route('admin.profile.index'));
        $this->put(route('admin.profile.password'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('admin.profile.edit'));

        $this->assertSame('Admin Baru', $admin->fresh()->name);
        $this->assertTrue(Hash::check('new-password', $admin->fresh()->password));
    }

    public function test_non_admin_cannot_access_admin_profile(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.profile.index'))
            ->assertForbidden();
    }
}
