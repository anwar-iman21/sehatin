<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_consultation_page_requires_login_and_stores_user_messages(): void
    {
        $this->get(route('consultation.index'))
            ->assertOk()
            ->assertSee('Konsultasi kesehatan')
            ->assertSee('Asisten informasi kesehatan umum')
            ->assertDontSee('AI bukan pengganti')
            ->assertDontSee('Asisten AI belum dikonfigurasi')
            ->assertSee(__('app.login_to_consult'));

        $this->postJson(route('consultation.chat'), ['message' => 'Pesan untuk admin'])
            ->assertUnauthorized();

        $user = User::factory()->create();
        $this->postJson(route('consultation.chat'), [
            'message' => 'Halo admin, saya butuh bantuan terkait kesehatan umum.',
        ])
            ->assertUnauthorized();

        $this->actingAs($user)->postJson(route('consultation.chat'), [
            'message' => 'Halo admin, saya butuh bantuan terkait kesehatan umum.',
        ])
            ->assertCreated()
            ->assertJsonPath('message.sender', 'user')
            ->assertJsonPath('message.body', 'Halo admin, saya butuh bantuan terkait kesehatan umum.');

        $this->assertDatabaseHas('consultation_messages', [
            'user_id' => $user->id,
            'sender' => 'user',
            'message' => 'Halo admin, saya butuh bantuan terkait kesehatan umum.',
        ]);

        $this->get(route('consultation.index'))->assertSee('Halo admin, saya butuh bantuan terkait kesehatan umum.');
    }

    public function test_admin_can_read_and_reply_to_a_user_consultation(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->get(route('admin.consultations.index'))
            ->assertOk()
            ->assertSee('class="admin-inbox-empty"', false)
            ->assertSee(__('app.consultation_empty_inbox_hint'));

        $incoming = $user->consultationMessages()->create([
            'sender' => 'user',
            'message' => 'Saya ingin bertanya tentang kesehatan.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.consultations.index'))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee('Saya ingin bertanya tentang kesehatan.');
        $this->getJson(route('admin.consultations.updates', ['after' => 0]))
            ->assertOk()
            ->assertJsonPath('messages.0.user.id', $user->id);

        $this->get(route('admin.consultations.show', $user))
            ->assertOk()
            ->assertSee('Saya ingin bertanya tentang kesehatan.');
        $this->getJson(route('admin.consultations.messages', [$user, 'after' => 0]))
            ->assertOk()
            ->assertJsonPath('messages.0.message', 'Saya ingin bertanya tentang kesehatan.');
        $this->assertNotNull($incoming->fresh()->read_at);

        $this->post(route('admin.consultations.reply', $user), [
            'message' => 'Terima kasih sudah menghubungi admin.',
        ])->assertRedirect(route('admin.consultations.show', $user));

        $reply = $user->consultationMessages()->where('sender', 'admin')->firstOrFail();
        $this->assertSame($admin->id, $reply->admin_id);

        $this->actingAs($user)
            ->get(route('consultation.index'))
            ->assertSee('Terima kasih sudah menghubungi admin.');
        $this->getJson(route('consultation.messages', ['after' => $incoming->id]))
            ->assertOk()
            ->assertJsonPath('messages.0.message', 'Terima kasih sudah menghubungi admin.');
    }

    public function test_inactive_conversation_resets_after_ten_minutes(): void
    {
        $user = User::factory()->create();
        $message = $user->consultationMessages()->create([
            'sender' => 'user',
            'message' => 'Percakapan ini akan kedaluwarsa.',
        ]);

        $this->travel(11)->minutes();
        $this->actingAs($user)
            ->getJson(route('consultation.messages', ['after' => $message->id]))
            ->assertOk()
            ->assertJsonPath('reset', true)
            ->assertJsonCount(0, 'messages');

        $this->assertDatabaseMissing('consultation_messages', ['id' => $message->id]);
    }

    public function test_admin_can_delete_an_entire_consultation(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $message = $user->consultationMessages()->create([
            'sender' => 'user',
            'message' => 'Mohon hapus percakapan ini.',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.consultations.destroy', $user))
            ->assertRedirect(route('admin.consultations.index'));

        $this->assertDatabaseMissing('consultation_messages', ['id' => $message->id]);
    }
}
