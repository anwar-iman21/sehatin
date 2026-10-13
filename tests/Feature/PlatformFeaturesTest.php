<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\CommunityReply;
use App\Models\CommunityThread;
use App\Models\Disease;
use App\Models\SearchHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_tools_search_and_sdg_pages_render_in_both_supported_locales(): void
    {
        foreach (['id', 'en'] as $locale) {
            $this->withSession(['locale' => $locale])
                ->get(route('health-tools.bmi'))
                ->assertOk()
                ->assertSee(__('app.bmi_title', [], $locale));

            $this->withSession(['locale' => $locale])
                ->get(route('health-tools.mental-quiz'))
                ->assertOk()
                ->assertSee(__('app.mental_quiz_disclaimer', [], $locale));

            $this->withSession(['locale' => $locale])
                ->get(route('search.index'))
                ->assertOk()
                ->assertSee(__('app.search_all', [], $locale));

            $this->withSession(['locale' => $locale])
                ->get(route('sdg'))
                ->assertOk()
                ->assertSee(__('app.sdg_title', [], $locale));
        }
    }

    public function test_search_includes_symptoms_suggests_results_and_records_user_history(): void
    {
        $disease = Disease::create([
            'name' => 'Seasonal allergy',
            'overview' => 'An immune response to airborne allergens.',
            'symptoms' => 'sneezing itchy eyes',
            'is_active' => true,
        ]);
        $user = User::factory()->create();

        $this->getJson(route('search.suggestions', ['q' => 'itchy eyes']))
            ->assertOk()
            ->assertJsonPath('suggestions.0.title', $disease->name)
            ->assertJsonPath('suggestions.0.url', route('penyakit.show', $disease));

        $this->actingAs($user)
            ->get(route('search.index', ['q' => 'itchy eyes']))
            ->assertOk()
            ->assertSee($disease->name);

        $this->assertDatabaseHas('search_histories', [
            'user_id' => $user->id,
            'query' => 'itchy eyes',
        ]);

        $this->get(route('search.index', ['q' => 'itchy eyes']))->assertOk();
        $this->assertDatabaseCount('search_histories', 1);
    }

    public function test_article_trust_metadata_is_visible_and_authenticated_pages_are_not_cached(): void
    {
        $author = User::factory()->create();
        $category = Category::create(['name' => 'Health', 'slug' => 'health']);
        $article = Article::create([
            'user_id' => $author->id,
            'category_id' => $category->id,
            'title' => 'A trusted health article',
            'slug' => 'trusted-health-article',
            'content' => '<p>Health information</p>',
            'status' => 'published',
            'published_at' => now(),
            'reviewer_name' => 'Dr. Ada',
            'last_reviewed_at' => today(),
            'references_json' => [['title' => 'WHO guidance', 'url' => 'https://www.who.int/']],
        ]);

        $outputBufferLevel = ob_get_level();
        try {
            $articleResponse = $this->get(route('artikel.show', $article));
            $articleResponse->assertOk();
            $articleResponse->assertHeader('Cache-Control', 'max-age=0, must-revalidate, public');
            $articleResponse->assertSee('Dr. Ada');
            $articleResponse->assertSee('WHO guidance');
            $articleResponse->assertSee(__('app.medical_disclaimer_title'));

            $this->actingAs(User::factory()->create())
                ->get(route('artikel.show', $article))
                ->assertOk()
                ->assertHeader('Cache-Control', 'no-store, private');
        } finally {
            while (ob_get_level() > $outputBufferLevel) {
                ob_end_clean();
            }
        }
    }

    public function test_dashboard_shows_saved_articles_and_supports_search_history_cleanup(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Health', 'slug' => 'health']);
        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Saved health article',
            'slug' => 'saved-health-article',
            'content' => '<p>Health information</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('profile.index'))
            ->assertOk()
            ->assertSee(__('app.saved_empty'));

        $this->postJson(route('artikel.bookmark', $article))
            ->assertOk()
            ->assertJsonPath('bookmarked', true);
        $this->get(route('search.index', ['q' => 'sleep hygiene']))->assertOk();
        $history = SearchHistory::query()->where('user_id', $user->id)->firstOrFail();

        $this->get(route('profile.index'))
            ->assertOk()
            ->assertSee($article->title)
            ->assertSee($history->query);

        $this->delete(route('profile.history.destroy', $history))
            ->assertRedirect();
        $this->assertDatabaseMissing('search_histories', ['id' => $history->id]);
    }

    public function test_community_reading_is_public_but_posting_and_reporting_require_login(): void
    {
        $owner = User::factory()->create();
        $thread = CommunityThread::create([
            'user_id' => $owner->id,
            'category' => 'mental',
            'title' => 'A supportive discussion',
            'body' => 'A community member is looking for helpful resources.',
        ]);

        $this->get(route('community.show', $thread))->assertOk();
        $threadData = [
            'category' => 'mental',
            'title' => 'A new health discussion',
            'body' => 'This is a supportive community conversation.',
        ];
        $this->post(route('community.store'), $threadData)->assertRedirect(route('login'));
        $this->post(route('community.report'), [
            'type' => 'thread',
            'id' => $thread->id,
            'reason' => 'misinformation',
        ])->assertRedirect(route('login'));

        $member = User::factory()->create();
        $this->actingAs($member)
            ->post(route('community.store'), $threadData)
            ->assertRedirect();
        $this->assertDatabaseHas('community_threads', [
            'user_id' => $member->id,
            'title' => $threadData['title'],
        ]);
        $memberThread = CommunityThread::where('user_id', $member->id)->where('title', $threadData['title'])->firstOrFail();
        $this->get(route('community.show', $memberThread))
            ->assertOk()
            ->assertSee(__('app.cannot_report_own_content'))
            ->assertDontSee('report-thread');
        $this->post(route('community.report'), [
            'type' => 'thread',
            'id' => $memberThread->id,
            'reason' => 'spam',
        ])->assertForbidden();

        $this->post(route('community.reply', $thread), [
            'body' => 'A helpful response from the community.',
        ])->assertRedirect();
        $this->assertDatabaseHas('community_replies', [
            'thread_id' => $thread->id,
            'user_id' => $member->id,
            'body' => 'A helpful response from the community.',
        ]);

        $this->post(route('community.report'), [
            'type' => 'thread',
            'id' => $thread->id,
            'reason' => 'misinformation',
        ])->assertRedirect();
        $this->assertDatabaseHas('community_reports', [
            'reporter_id' => $member->id,
            'reportable_type' => CommunityThread::class,
            'reportable_id' => $thread->id,
            'reason' => 'misinformation',
            'status' => 'pending',
        ]);

        $admin = User::factory()->create(['role' => 'admin']);
        $reportId = $thread->reports()->firstOrFail()->id;
        $this->actingAs($admin)
            ->get(route('admin.community.moderation'))
            ->assertOk()
            ->assertSee(route('admin.community.moderation'), false)
            ->assertDontSee($admin->email)
            ->assertSee($thread->title);
        $this->post(route('admin.community.reports.resolve', $reportId))
            ->assertRedirect();
        $this->assertDatabaseHas('community_reports', ['id' => $reportId, 'status' => 'reviewed']);
    }

    public function test_admin_verification_marks_doctor_replies_as_verified(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $doctor = User::factory()->create(['is_verified_doctor' => false]);
        $thread = CommunityThread::create([
            'user_id' => User::factory()->create()->id,
            'category' => 'mental',
            'title' => 'Doctor response discussion',
            'body' => 'Discussion about a question for a healthcare professional.',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.community.doctors.verify', $doctor))
            ->assertRedirect();

        $this->assertTrue($doctor->fresh()->is_verified_doctor);
        $doctor = $doctor->fresh();
        $this->actingAs($doctor)
            ->post(route('community.reply', $thread), [
                'body' => 'Please consult a clinician for individual advice.',
            ])
            ->assertRedirect();
        $this->assertTrue(CommunityReply::query()->firstOrFail()->doctor_verified);
        $this->get(route('community.show', $thread))
            ->assertOk()
            ->assertSee(__('app.verified_doctor'));
    }

    public function test_admin_can_delete_reported_replies_or_discussions_and_resolve_related_reports(): void
    {
        $owner = User::factory()->create();
        $reporter = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $thread = CommunityThread::create([
            'user_id' => $owner->id,
            'category' => 'mental',
            'title' => 'Reported discussion title',
            'body' => 'A discussion body that moderators can remove.',
        ]);
        $reply = CommunityReply::create([
            'thread_id' => $thread->id,
            'user_id' => $owner->id,
            'body' => 'A reported reply that moderators can remove.',
        ]);
        $threadReport = $thread->reports()->create([
            'reporter_id' => $reporter->id,
            'reason' => 'spam',
        ]);
        $replyReport = $reply->reports()->create([
            'reporter_id' => $reporter->id,
            'reason' => 'abuse',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.community.moderation'))
            ->assertOk()
            ->assertSee('Reported discussion title')
            ->assertSee('A reported reply that moderators can remove.')
            ->assertSee(route('admin.community.reports.destroy-content', $threadReport), false);

        $this->post(route('admin.community.reports.destroy-content', $replyReport))
            ->assertRedirect();
        $this->assertDatabaseMissing('community_replies', ['id' => $reply->id]);
        $this->assertDatabaseHas('community_reports', ['id' => $replyReport->id, 'status' => 'reviewed']);

        $this->post(route('admin.community.reports.destroy-content', $threadReport))
            ->assertRedirect();
        $this->assertDatabaseMissing('community_threads', ['id' => $thread->id]);
        $this->assertDatabaseHas('community_reports', ['id' => $threadReport->id, 'status' => 'reviewed']);
    }

}
